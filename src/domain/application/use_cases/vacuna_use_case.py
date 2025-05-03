from typing import List, Optional
from domain.entities.vacuna import Vacuna
from domain.repositories.vacuna_repository import VacunaRepository

class VacunaUseCase:
    def __init__(self, vacuna_repository: VacunaRepository):
        self.vacuna_repository = vacuna_repository

    async def get_by_id(self, id: int) -> Optional[Vacuna]:
        return await self.vacuna_repository.get_by_id(id)

    async def get_all(self) -> List[Vacuna]:
        return await self.vacuna_repository.get_all()

    async def create(self, vacuna: Vacuna) -> Vacuna:
        return await self.vacuna_repository.create(vacuna)

    async def update(self, id: int, vacuna: Vacuna) -> Optional[Vacuna]:
        return await self.vacuna_repository.update(id, vacuna)

    async def delete(self, id: int) -> bool:
        return await self.vacuna_repository.delete(id)