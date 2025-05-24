from flask import Blueprint
from presentation.controllers import vacuna_controller

vacuna_bp = Blueprint('vacuna_bp', __name__)

@vacuna_bp.route('/vacunas', methods=['GET'])
def obtener_vacunas():
    return vacuna_controller.get_all()

@vacuna_bp.route('/vacunas/<int:id>', methods=['GET'])
def obtener_vacuna_por_id(id):
    return vacuna_controller.get_by_id(id)

@vacuna_bp.route('/vacunas', methods=['POST'])
def crear_vacuna():
    return vacuna_controller.create()

@vacuna_bp.route('/vacunas/<int:id>', methods=['PUT'])
def actualizar_vacuna(id):
    return vacuna_controller.update(id)

@vacuna_bp.route('/vacunas/<int:id>', methods=['DELETE'])
def eliminar_vacuna(id):
    return vacuna_controller.delete(id)
