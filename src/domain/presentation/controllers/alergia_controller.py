from typing import List
from fastapi import HTTPException, status
from application.use_cases.alergia_use_case import AlergiaUseCase
from domain.entities.alergia import Alergia

class AlergiaController:
    def __init__(self, alergia_use_case: AlergiaUseCase):
        self.alergia_use_case = alergia_use_case

    async def get_all(self) -> List[Alergia]:
        try:
            return await self.alergia_use_case.get_all()
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener las alergias: {e}")

    async def get_by_id(self, id: int) -> Alergia:
        try:
            alergia = await self.alergia_use_case.get_by_id(id)
            if not alergia:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Alergia no encontrada")
            return alergia
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener la alergia: {e}")

    async def create(self, alergia_data: Alergia) -> Alergia:
        try:
            created = await self.alergia_use_case.create(alergia_data)
            return created
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al crear la alergia: {e}")

    async def update(self, id: int, alergia_data: Alergia) -> Alergia:
        try:
            updated = await self.alergia_use_case.update(id, alergia_data)
            if not updated:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Alergia no encontrada para actualizar")
            return updated
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al actualizar la alergia: {e}")

    async def delete(self, id: int) -> dict:
        try:
            deleted = await self.alergia_use_case.delete(id)
            if not deleted:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Alergia no encontrada para eliminar")
            return {"message": "Alergia eliminada exitosamente"}
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al eliminar la alergia: {e}")