from abc import ABC, abstractmethod
from typing import List, Optional
from domain.entities.mascota import Mascota

class MascotaRepository(ABC):
    @abstractmethod
    async def get_by_id(self, id: int) -> Optional[Mascota]:
        pass

    @abstractmethod
    async def get_all(self) -> List[Mascota]:
        pass

    @abstractmethod
    async def create(self, mascota: Mascota) -> Mascota:
        pass

    @abstractmethod
    async def update(self, id: int, mascota: Mascota) -> Optional[Mascota]:
        pass

    @abstractmethod
    async def delete(self, id: int) -> bool:
        pass