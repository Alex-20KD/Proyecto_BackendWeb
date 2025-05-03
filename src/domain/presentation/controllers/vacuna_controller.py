from typing import List
from fastapi import HTTPException, status
from application.use_cases.vacuna_use_case import VacunaUseCase
from domain.entities.vacuna import Vacuna

class VacunaController:
    def __init__(self, vacuna_use_case: VacunaUseCase):
        self.vacuna_use_case = vacuna_use_case

    async def get_all(self) -> List[Vacuna]:
        try:
            return await self.vacuna_use_case.get_all()
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener las vacunas: {e}")

    async def get_by_id(self, id: int) -> Vacuna:
        try:
            vacuna = await self.vacuna_use_case.get_by_id(id)
            if not vacuna:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Vacuna no encontrada")
            return vacuna
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener la vacuna: {e}")

    async def create(self, vacuna_data: Vacuna) -> Vacuna:
        try:
            created = await self.vacuna_use_case.create(vacuna_data)
            return created
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al crear la vacuna: {e}")

    async def update(self, id: int, vacuna_data: Vacuna) -> Vacuna:
        try:
            updated = await self.vacuna_use_case.update(id, vacuna_data)
            if not updated:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Vacuna no encontrada para actualizar")
            return updated
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al actualizar la vacuna: {e}")

    async def delete(self, id: int) -> dict:
        try:
            deleted = await self.vacuna_use_case.delete(id)
            if not deleted:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Vacuna no encontrada para eliminar")
            return {"message": "Vacuna eliminada exitosamente"}
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al eliminar la vacuna: {e}")