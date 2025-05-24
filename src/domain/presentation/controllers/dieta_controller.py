from flask import jsonify, request
from aplication.uses_cases.dieta_usecase import DietaUseCase
from domain.repositories.dieta_repository import DietaRepository

repo = DietaRepository()
use_case = DietaUseCase(repo)

def get_all():
    dietas = use_case.obtener_todos()
    return {"dietas": [d.to_dict() for d in dietas]}

def get_by_id(id):
    d = use_case.obtener_por_id(id)
    if d:
        return jsonify(d.to_dict())
    return jsonify({"error": "Dieta no encontrada"}), 404

def create():
    data = request.json
    dieta = use_case.crear(data)
    return jsonify(dieta), 201

def update(id):
    data = request.json
    d = use_case.actualizar(id, data)
    if d:
        return jsonify(d.to_dict())
    return jsonify({"error": "Dieta no encontrada"}), 404

def delete(id):
    eliminado = use_case.eliminar(id)
    if eliminado:
        return jsonify({"mensaje": "Dieta eliminada"})
    return jsonify({"mensaje": "No encontrada"}), 404
