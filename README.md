## Módulo de Inteligencia Artificial

### Justificación Técnica

Se ha integrado un servicio de IA (Gemini de Google) para analizar el texto de las observaciones en los informes de seguimiento de adopción. El objetivo de esta funcionalidad es mejorar el bienestar animal y optimizar los recursos de la organización.

**Funcionamiento:**
1.  Un voluntario o empleado realiza una visita de seguimiento y anota sus observaciones en el sistema.
2.  A través de un endpoint seguro, se pueden enviar estas observaciones a la IA.
3.  La IA procesa el lenguaje natural del texto y devuelve un análisis estructurado que incluye:
    * **Clasificación:** Un indicador rápido (`Positivo`, `Neutral`, `Requiere Atención`).
    * **Resumen:** Un texto corto que extrae los puntos clave del informe.

**Beneficios:**
* **Priorización Eficiente:** Permite a los coordinadores identificar rápidamente las adopciones que presentan problemas (`Requiere Atención`) sin necesidad de leer todos los informes en detalle.
* **Intervención Temprana:** Al detectar señales de alerta de forma automática, se pueden programar visitas de seguimiento adicionales o contactar al adoptante de manera proactiva, previniendo posibles devoluciones o situaciones de riesgo para el animal.
* **Análisis de Datos a Escala:** A futuro, los datos estructurados generados por la IA pueden ser utilizados para analizar tendencias y patrones en los procesos de adopción.