from sqlalchemy.ext.asyncio import create_async_engine, AsyncSession, async_sessionmaker
from sqlalchemy.orm import declarative_base
from pydantic_settings import BaseSettings, SettingsConfigDict
from contextlib import asynccontextmanager

# Configuración de Pydantic Settings para cargar variables de entorno
class Settings(BaseSettings):
    # Por defecto, intenta cargar de .env. Si no lo encuentra, usa esta URL.
    # Asegúrate de que esta URL coincida con tu configuración de PostgreSQL.
    # Formato: postgresql+asyncpg://usuario:contraseña@host:puerto/nombre_bd
    DATABASE_URL: str = "postgresql+asyncpg://user:1234@localhost:3000/mydatabase"

    model_config = SettingsConfigDict(env_file='.env', extra='ignore')

# Instancia de las configuraciones para que puedan ser accedidas
settings = Settings()

# Motor de base de datos asíncrono. 'echo=True' mostrará las consultas SQL en la consola.
engine = create_async_engine(settings.DATABASE_URL, echo=True)

# Base declarativa para tus modelos ORM. Todos tus modelos de SQLAlchemy (MascotaModel, etc.)
# deben heredar de esta 'Base'.
Base = declarative_base()

# Generador de sesiones asíncronas.
# 'autocommit=False', 'autoflush=False': Controlan manualmente los commits y flushes.
# 'bind=engine': Asocia las sesiones con el motor de base de datos.
# 'class_=AsyncSession': Indica que usaremos sesiones asíncronas.
# 'expire_on_commit=False': Los objetos no expiran después de un commit, lo que es útil
#                          cuando necesitas acceder a ellos después de guardarlos.
AsyncSessionLocal = async_sessionmaker(
    autocommit=False,
    autoflush=False,
    bind=engine,
    class_=AsyncSession,
    expire_on_commit=False
)

# Dependencia para obtener una sesión de base de datos.
# FastAPI la usará para inyectar una sesión a tus rutas y controladores.
@asynccontextmanager
async def get_db():
    async with AsyncSessionLocal() as session:
        try:
            yield session # Proporciona la sesión al bloque 'with'
        finally:
            await session.close() # Asegura que la sesión se cierre después de su uso

async def init_db():
    """
    Función para crear todas las tablas definidas en tus modelos en la base de datos.
    Debe ser llamada al inicio de la aplicación, por ejemplo, en el evento 'lifespan' de FastAPI.
    """
    async with engine.begin() as conn:
        await conn.run_sync(Base.metadata.create_all)