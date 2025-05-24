from flask import Blueprint
from presentation.controllers import dieta_controller

dieta_bp = Blueprint('dieta_bp', __name__)

@dieta_bp.route('/dietas', methods=['GET'])
def obtener_dietas():
    return dieta_controller.get_all()

@dieta_bp.route('/dietas/<int:id>', methods=['GET'])
def obtener_dieta_por_id(id):
    return dieta_controller.get_by_id(id)

@dieta_bp.route('/dietas', methods=['POST'])
def crear_dieta():
    return dieta_controller.create()

@dieta_bp.route('/dietas/<int:id>', methods=['PUT'])
def actualizar_dieta(id):
    return dieta_controller.update(id)

@dieta_bp.route('/dietas/<int:id>', methods=['DELETE'])
def eliminar_dieta(id):
    return dieta_controller.delete(id)
