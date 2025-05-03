from fastapi import APIRouter, Depends, status
from sqlalchemy.ext.asyncio import AsyncSession
from typing import List
from infrastructure.database.config import get_db
from domain.repositories.alergia_repository import SQLAlchemyAlergiaRepository
from application.use_cases.alergia_use_case import AlergiaUseCase
from presentation.controllers.alergia_controller import AlergiaController
from domain.entities.alergia import Alergia

router = APIRouter(prefix="/alergias", tags=["Alergias"])

async def get_alergia_controller(db_session: AsyncSession = Depends(get_db)) -> AlergiaController:
    repository = SQLAlchemyAlergiaRepository(db_session)
    use_case = AlergiaUseCase(repository)
    return AlergiaController(use_case)

@router.get("/{id}", response_model=Alergia, summary="Obtener alergia por ID")
async def get_alergia_by_id(
    id: int,
    controller: AlergiaController = Depends(get_alergia_controller)
):
    return await controller.get_by_id(id)

@router.get("/", response_model=List[Alergia], summary="Obtener todas las alergias")
async def get_all_alergias(
    controller: AlergiaController = Depends(get_alergia_controller)
):
    return await controller.get_all()

@router.post("/", response_model=Alergia, status_code=status.HTTP_201_CREATED, summary="Crear una nueva alergia")
async def create_alergia(
    alergia_data: Alergia,
    controller: AlergiaController = Depends(get_alergia_controller)
):
    return await controller.create(alergia_data)

@router.put("/{id}", response_model=Alergia, summary="Actualizar alergia por ID")
async def update_alergia(
    id: int,
    alergia_data: Alergia,
    controller: AlergiaController = Depends(get_alergia_controller)
):
    return await controller.update(id, alergia_data)

@router.delete("/{id}", status_code=status.HTTP_200_OK, summary="Eliminar alergia por ID")
async def delete_alergia(
    id: int,
    controller: AlergiaController = Depends(get_alergia_controller)
):
    return await controller.delete(id)