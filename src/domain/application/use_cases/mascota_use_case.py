from typing import List, Optional
from domain.entities.mascota import Mascota
from domain.repositories.mascota_repository import MascotaRepository

class MascotaUseCase:
    def __init__(self, mascota_repository: MascotaRepository):
        self.mascota_repository = mascota_repository

    async def get_by_id(self, id: int) -> Optional[Mascota]:
        return await self.mascota_repository.get_by_id(id)

    async def get_all(self) -> List[Mascota]:
        return await self.mascota_repository.get_all()

    async def create(self, mascota: Mascota) -> Mascota:
        return await self.mascota_repository.create(mascota)

    async def update(self, id: int, mascota: Mascota) -> Optional[Mascota]:
        return await self.mascota_repository.update(id, mascota)

    async def delete(self, id: int) -> bool:
        return await self.mascota_repository.delete(id)