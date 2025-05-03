from typing import List
from fastapi import HTTPException, status
from application.use_cases.mascota_use_case import MascotaUseCase
from domain.entities.mascota import Mascota

class MascotaController:
    def __init__(self, mascota_use_case: MascotaUseCase):
        self.mascota_use_case = mascota_use_case

    async def get_all(self) -> List[Mascota]:
        try:
            return await self.mascota_use_case.get_all()
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener las mascotas: {e}")

    async def get_by_id(self, id: int) -> Mascota:
        try:
            mascota = await self.mascota_use_case.get_by_id(id)
            if not mascota:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Mascota no encontrada")
            return mascota
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener la mascota: {e}")

    async def create(self, mascota_data: Mascota) -> Mascota:
        try:
            created = await self.mascota_use_case.create(mascota_data)
            return created
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al crear la mascota: {e}")

    async def update(self, id: int, mascota_data: Mascota) -> Mascota:
        try:
            updated = await self.mascota_use_case.update(id, mascota_data)
            if not updated:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Mascota no encontrada para actualizar")
            return updated
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al actualizar la mascota: {e}")

    async def delete(self, id: int) -> dict:
        try:
            deleted = await self.mascota_use_case.delete(id)
            if not deleted:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Mascota no encontrada para eliminar")
            return {"message": "Mascota eliminada exitosamente"}
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al eliminar la mascota: {e}")