from typing import List, Optional
from domain.entities.alergia import Alergia
from domain.repositories.alergia_repository import AlergiaRepository

class AlergiaUseCase:
    def __init__(self, alergia_repository: AlergiaRepository):
        self.alergia_repository = alergia_repository

    async def get_by_id(self, id: int) -> Optional[Alergia]:
        return await self.alergia_repository.get_by_id(id)

    async def get_all(self) -> List[Alergia]:
        return await self.alergia_repository.get_all()

    async def create(self, alergia: Alergia) -> Alergia:
        return await self.alergia_repository.create(alergia)

    async def update(self, id: int, alergia: Alergia) -> Optional[Alergia]:
        return await self.alergia_repository.update(id, alergia)

    async def delete(self, id: int) -> bool:
        return await self.alergia_repository.delete(id)