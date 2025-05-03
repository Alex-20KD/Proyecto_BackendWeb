from fastapi import APIRouter, Depends, status
from sqlalchemy.ext.asyncio import AsyncSession
from typing import List
from infrastructure.database.config import get_db
from domain.repositories.vacuna_repository import SQLAlchemyVacunaRepository
from application.use_cases.vacuna_use_case import VacunaUseCase
from presentation.controllers.vacuna_controller import VacunaController
from domain.entities.vacuna import Vacuna

router = APIRouter(prefix="/vacunas", tags=["Vacunas"])

async def get_vacuna_controller(db_session: AsyncSession = Depends(get_db)) -> VacunaController:
    repository = SQLAlchemyVacunaRepository(db_session)
    use_case = VacunaUseCase(repository)
    return VacunaController(use_case)

@router.get("/{id}", response_model=Vacuna, summary="Obtener vacuna por ID")
async def get_vacuna_by_id(
    id: int,
    controller: VacunaController = Depends(get_vacuna_controller)
):
    return await controller.get_by_id(id)

@router.get("/", response_model=List[Vacuna], summary="Obtener todas las vacunas")
async def get_all_vacunas(
    controller: VacunaController = Depends(get_vacuna_controller)
):
    return await controller.get_all()

@router.post("/", response_model=Vacuna, status_code=status.HTTP_201_CREATED, summary="Crear una nueva vacuna")
async def create_vacuna(
    vacuna_data: Vacuna,
    controller: VacunaController = Depends(get_vacuna_controller)
):
    return await controller.create(vacuna_data)

@router.put("/{id}", response_model=Vacuna, summary="Actualizar vacuna por ID")
async def update_vacuna(
    id: int,
    vacuna_data: Vacuna,
    controller: VacunaController = Depends(get_vacuna_controller)
):
    return await controller.update(id, vacuna_data)

@router.delete("/{id}", status_code=status.HTTP_200_OK, summary="Eliminar vacuna por ID")
async def delete_vacuna(
    id: int,
    controller: VacunaController = Depends(get_vacuna_controller)
):
    return await controller.delete(id)