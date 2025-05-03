# src/main.py
from fastapi import FastAPI
from contextlib import asynccontextmanager
import uvicorn

# Importaciones desde tu infraestructura de base de datos
from infrastructure.database.config import engine, Base

# Importa todos los routers de tus entidades para que la API los reconozca
from presentation.routes.mascota_route import router as mascota_router
from presentation.routes.historial_medico_route import router as historial_medico_router
from presentation.routes.vacuna_route import router as vacuna_router
from presentation.routes.dieta_route import router as dieta_router
from presentation.routes.alergia_route import router as alergia_router


@asynccontextmanager
async def lifespan(app: FastAPI):
    """
    Función que se ejecuta cuando la aplicación FastAPI se inicia y cuando se apaga.
    Aquí creamos todas las tablas de la base de datos si aún no existen.
    """
    print("Iniciando la aplicación y creando/verificando tablas en la base de datos...")
    async with engine.begin() as conn:
        await conn.run_sync(Base.metadata.create_all)
    print("Tablas creadas o ya existentes verificadas correctamente.")
    yield # Aquí es donde la aplicación comienza a procesar las solicitudes
    print("Cerrando la aplicación y liberando recursos.")


# Inicialización de la aplicación FastAPI
app = FastAPI(
    title="API de Gestión de Mascotas y su Historial Médico",
    description="Una API robusta para administrar mascotas y sus datos asociados, construida con Python y FastAPI.",
    version="1.0.0",
    lifespan=lifespan # Conectamos la función lifespan para el manejo de la DB
)

# Incluimos todos los routers para que sus endpoints estén disponibles
app.include_router(mascota_router)
app.include_router(historial_medico_router)
app.include_router(vacuna_router)
app.include_router(dieta_router)
app.include_router(alergia_router)


# Ruta principal para verificar el estado de la API
@app.get("/", summary="Ruta de bienvenida")
async def read_root():
    return {"message": "¡Bienvenido a la API de Gestión de Mascotas! Accede a /docs para la documentación interactiva."}


# Esto permite ejecutar la aplicación directamente con 'python src/main.py'
# pero la forma recomendada para desarrollo es 'uvicorn src.main:app --reload'.
if __name__ == "__main__":
    uvicorn.run(
        "main:app",
        host="0.0.0.0", # Permite que la API sea accesible desde otras máquinas en la red local
        port=8000,     # Puerto predeterminado para FastAPI
        reload=True,   # Recarga la aplicación automáticamente con cada cambio de código
        app_dir="src"  # Indica a Uvicorn dónde encontrar el archivo 'main.py'
    )