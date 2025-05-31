// Application/Interfaces/Services/IAIService.cs
public interface IAIService
{
    Task<string> AnalizarBienestarAnimalAsync(string observaciones);
}

// Infrastructure/Services/GeminiService.cs
// (Necesitarás instalar `dotnet add Infrastructure/Infrastructure.csproj package System.Text.Json`)
using System.Text;
using System.Text.Json;

public class GeminiService : IAIService
{
    private readonly HttpClient _httpClient;
    private readonly string _apiKey;

    public GeminiService(HttpClient httpClient, IConfiguration configuration)
    {
        _httpClient = httpClient;
        _apiKey = configuration["AIzaSyA3X7MbwNtDx1JjWhUm0tagST-KTyN91PM"];
    }

    public async Task<string> AnalizarBienestarAnimalAsync(string observaciones)
    {
        var apiUrl = $"https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={_apiKey}";
        
        var prompt = $"Analiza el siguiente texto de un informe de seguimiento de adopción y determina el bienestar del animal. Devuelve solo un objeto JSON con dos claves: 'clasificacion' ('Positivo', 'Neutral', 'Requiere Atencion') y 'resumen' (un resumen de 20 palabras). Texto: '{observaciones}'";

        var payload = new { contents = new[] { new { parts = new[] { new { text = prompt } } } } };
        var jsonPayload = JsonSerializer.Serialize(payload);
        var content = new StringContent(jsonPayload, Encoding.UTF8, "application/json");

        var response = await _httpClient.PostAsync(apiUrl, content);
        if (!response.IsSuccessStatusCode) return null;

        var jsonResponse = await response.Content.ReadAsStringAsync();
        // Aquí necesitarías un parsing más robusto del JSON de respuesta de Gemini
        // para extraer el texto de la respuesta.
        return jsonResponse; 
    }
}