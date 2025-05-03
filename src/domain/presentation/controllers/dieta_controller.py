from typing import List
from fastapi import HTTPException, status
from application.use_cases.dieta_use_case import DietaUseCase
from domain.entities.dieta import Dieta

class DietaController:
    def __init__(self, dieta_use_case: DietaUseCase):
        self.dieta_use_case = dieta_use_case

    async def get_all(self) -> List[Dieta]:
        try:
            return await self.dieta_use_case.get_all()
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener las dietas: {e}")

    async def get_by_id(self, id: int) -> Dieta:
        try:
            dieta = await self.dieta_use_case.get_by_id(id)
            if not dieta:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Dieta no encontrada")
            return dieta
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener la dieta: {e}")

    async def create(self, dieta_data: Dieta) -> Dieta:
        try:
            created = await self.dieta_use_case.create(dieta_data)
            return created
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al crear la dieta: {e}")

    async def update(self, id: int, dieta_data: Dieta) -> Dieta:
        try:
            updated = await self.dieta_use_case.update(id, dieta_data)
            if not updated:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Dieta no encontrada para actualizar")
            return updated
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al actualizar la dieta: {e}")

    async def delete(self, id: int) -> dict:
        try:
            deleted = await self.dieta_use_case.delete(id)
            if not deleted:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Dieta no encontrada para eliminar")
            return {"message": "Dieta eliminada exitosamente"}
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al eliminar la dieta: {e}")