from fastapi import APIRouter, Depends, status
from sqlalchemy.ext.asyncio import AsyncSession
from typing import List
from infrastructure.database.config import get_db
from domain.repositories.dieta_repository import SQLAlchemyDietaRepository
from application.use_cases.dieta_use_case import DietaUseCase
from presentation.controllers.dieta_controller import DietaController
from domain.entities.dieta import Dieta

router = APIRouter(prefix="/dietas", tags=["Dietas"])

async def get_dieta_controller(db_session: AsyncSession = Depends(get_db)) -> DietaController:
    repository = SQLAlchemyDietaRepository(db_session)
    use_case = DietaUseCase(repository)
    return DietaController(use_case)

@router.get("/{id}", response_model=Dieta, summary="Obtener dieta por ID")
async def get_dieta_by_id(
    id: int,
    controller: DietaController = Depends(get_dieta_controller)
):
    return await controller.get_by_id(id)

@router.get("/", response_model=List[Dieta], summary="Obtener todas las dietas")
async def get_all_dietas(
    controller: DietaController = Depends(get_dieta_controller)
):
    return await controller.get_all()

@router.post("/", response_model=Dieta, status_code=status.HTTP_201_CREATED, summary="Crear una nueva dieta")
async def create_dieta(
    dieta_data: Dieta,
    controller: DietaController = Depends(get_dieta_controller)
):
    return await controller.create(dieta_data)

@router.put("/{id}", response_model=Dieta, summary="Actualizar dieta por ID")
async def update_dieta(
    id: int,
    dieta_data: Dieta,
    controller: DietaController = Depends(get_dieta_controller)
):
    return await controller.update(id, dieta_data)

@router.delete("/{id}", status_code=status.HTTP_200_OK, summary="Eliminar dieta por ID")
async def delete_dieta(
    id: int,
    controller: DietaController = Depends(get_dieta_controller)
):
    return await controller.delete(id)