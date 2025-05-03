from typing import List, Optional
from domain.entities.historial_medico import HistorialMedico
from domain.repositories.historial_medico_repository import HistorialMedicoRepository

class HistorialMedicoUseCase:
    def __init__(self, historial_medico_repository: HistorialMedicoRepository):
        self.historial_medico_repository = historial_medico_repository

    async def get_by_id(self, id: int) -> Optional[HistorialMedico]:
        return await self.historial_medico_repository.get_by_id(id)

    async def get_all(self) -> List[HistorialMedico]:
        return await self.historial_medico_repository.get_all()

    async def create(self, historial_medico: HistorialMedico) -> HistorialMedico:
        return await self.historial_medico_repository.create(historial_medico)

    async def update(self, id: int, historial_medico: HistorialMedico) -> Optional[HistorialMedico]:
        return await self.historial_medico_repository.update(id, historial_medico)

    async def delete(self, id: int) -> bool:
        return await self.historial_medico_repository.delete(id)