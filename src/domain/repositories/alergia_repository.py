from abc import ABC, abstractmethod
from typing import List, Optional
from domain.entities.alergia import Alergia

class AlergiaRepository(ABC):
    @abstractmethod
    async def get_by_id(self, id: int) -> Optional[Alergia]: pass
    @abstractmethod
    async def get_all(self) -> List[Alergia]: pass
    @abstractmethod
    async def create(self, alergia: Alergia) -> Alergia: pass
    @abstractmethod
    async def update(self, id: int, alergia: Alergia) -> Optional[Alergia]: pass
    @abstractmethod
    async def delete(self, id: int) -> bool: pass