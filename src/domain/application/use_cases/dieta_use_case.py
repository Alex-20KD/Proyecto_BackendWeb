from typing import List, Optional
from domain.entities.dieta import Dieta
from domain.repositories.dieta_repository import DietaRepository

class DietaUseCase:
    def __init__(self, dieta_repository: DietaRepository):
        self.dieta_repository = dieta_repository

    async def get_by_id(self, id: int) -> Optional[Dieta]:
        return await self.dieta_repository.get_by_id(id)

    async def get_all(self) -> List[Dieta]:
        return await self.dieta_repository.get_all()

    async def create(self, dieta: Dieta) -> Dieta:
        return await self.dieta_repository.create(dieta)

    async def update(self, id: int, dieta: Dieta) -> Optional[Dieta]:
        return await self.dieta_repository.update(id, dieta)

    async def delete(self, id: int) -> bool:
        return await self.dieta_repository.delete(id)