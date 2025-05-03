from typing import List
from fastapi import HTTPException, status
from application.use_cases.historial_medico_use_case import HistorialMedicoUseCase
from domain.entities.historial_medico import HistorialMedico

class HistorialMedicoController:
    def __init__(self, historial_medico_use_case: HistorialMedicoUseCase):
        self.historial_medico_use_case = historial_medico_use_case

    async def get_all(self) -> List[HistorialMedico]:
        try:
            return await self.historial_medico_use_case.get_all()
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener los historiales médicos: {e}")

    async def get_by_id(self, id: int) -> HistorialMedico:
        try:
            historial = await self.historial_medico_use_case.get_by_id(id)
            if not historial:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Historial médico no encontrado")
            return historial
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al obtener el historial médico: {e}")

    async def create(self, historial_data: HistorialMedico) -> HistorialMedico:
        try:
            created = await self.historial_medico_use_case.create(historial_data)
            return created
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al crear el historial médico: {e}")

    async def update(self, id: int, historial_data: HistorialMedico) -> HistorialMedico:
        try:
            updated = await self.historial_medico_use_case.update(id, historial_data)
            if not updated:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Historial médico no encontrado para actualizar")
            return updated
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al actualizar el historial médico: {e}")

    async def delete(self, id: int) -> dict:
        try:
            deleted = await self.historial_medico_use_case.delete(id)
            if not deleted:
                raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="Historial médico no encontrado para eliminar")
            return {"message": "Historial médico eliminado exitosamente"}
        except HTTPException:
            raise
        except Exception as e:
            raise HTTPException(status_code=status.HTTP_500_INTERNAL_SERVER_ERROR, detail=f"Error al eliminar el historial médico: {e}")