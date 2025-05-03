from fastapi import APIRouter, Depends, status
from sqlalchemy.ext.asyncio import AsyncSession
from typing import List
from infrastructure.database.config import get_db
from domain.repositories.sqlalchemy_mascota_repository import SQLAlchemyMascotaRepository
from application.use_cases.mascota_use_case import MascotaUseCase
from presentation.controllers.mascota_controller import MascotaController
from domain.entities.mascota import Mascota

router = APIRouter(prefix="/mascotas", tags=["Mascotas"])

async def get_mascota_controller(db_session: AsyncSession = Depends(get_db)) -> MascotaController:
    repository = SQLAlchemyMascotaRepository(db_session)
    use_case = MascotaUseCase(repository)
    return MascotaController(use_case)

@router.get("/{id}", response_model=Mascota, summary="Obtener mascota por ID")
async def get_mascota_by_id(
    id: int,
    controller: MascotaController = Depends(get_mascota_controller)
):
    return await controller.get_by_id(id)

@router.get("/", response_model=List[Mascota], summary="Obtener todas las mascotas")
async def get_all_mascotas(
    controller: MascotaController = Depends(get_mascota_controller)
):
    return await controller.get_all()

@router.post("/", response_model=Mascota, status_code=status.HTTP_201_CREATED, summary="Crear una nueva mascota")
async def create_mascota(
    mascota_data: Mascota,
    controller: MascotaController = Depends(get_mascota_controller)
):
    return await controller.create(mascota_data)

@router.put("/{id}", response_model=Mascota, summary="Actualizar mascota por ID")
async def update_mascota(
    id: int,
    mascota_data: Mascota,
    controller: MascotaController = Depends(get_mascota_controller)
):
    return await controller.update(id, mascota_data)

@router.delete("/{id}", status_code=status.HTTP_200_OK, summary="Eliminar mascota por ID")
async def delete_mascota(
    id: int,
    controller: MascotaController = Depends(get_mascota_controller)
):
    return await controller.delete(id)