// -------------------- PASO 1: AÑADE ESTO AL PRINCIPIO DEL ARCHIVO --------------------
using Infrastructure.Data;
using Microsoft.EntityFrameworkCore;
// ---- USINGS AÑADIDOS ----
using Application.Interfaces.Repositories;
using Application.Interfaces.Services;
using Application.Services;
using Infrastructure.Repositories;
// -------------------------

var builder = WebApplication.CreateBuilder(args);

// -------------------- PASO 2: AÑADE TU DBCONTEXT AQUÍ --------------------------------
builder.Services.AddDbContext<AdopcionAnimalDbContext>(options =>
    options.UseNpgsql(builder.Configuration.GetConnectionString("DefaultConnection")));

// ---- LÍNEAS PARA LA INYECCIÓN DE DEPENDENCIAS ----
// Repositorios
builder.Services.AddScoped<IAdopcionRepository, AdopcionRepository>();
builder.Services.AddScoped<ICertificadoPropiedadRepository, CertificadoPropiedadRepository>();
builder.Services.AddScoped<IContratoAdopcionRepository, ContratoAdopcionRepository>();
builder.Services.AddScoped<IDocumentacionMascotaRepository, DocumentacionMascotaRepository>();
builder.Services.AddScoped<ISeguimientoAdopcionRepository, SeguimientoAdopcionRepository>(); // <-- NUEVA LÍNEA

// Servicios
builder.Services.AddScoped<IAdopcionService, AdopcionService>();
builder.Services.AddScoped<ICertificadoPropiedadService, CertificadoPropiedadService>();
builder.Services.AddScoped<IContratoAdopcionService, ContratoAdopcionService>();
builder.Services.AddScoped<IDocumentacionMascotaService, DocumentacionMascotaService>();
builder.Services.AddScoped<ISeguimientoAdopcionService, SeguimientoAdopcionService>(); // <-- NUEVA LÍNEA
// ---------------------------------------------------

// Esto es necesario si vas a usar controladores tipo API.
builder.Services.AddControllers();

// Para que funcione la documentación de tus futuros endpoints
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();


var app = builder.Build();

if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI();
}

app.UseHttpsRedirection();

// AQUÍ DEBERÍAS ELIMINAR EL ENDPOINT DE EJEMPLO "/weatherforecast"
// Y EN SU LUGAR, MÁS ADELANTE, CREARÁS LOS TUYOS.
var summaries = new[]
{
    "Freezing", "Bracing", "Chilly", "Cool", "Mild", "Warm", "Balmy", "Hot", "Sweltering", "Scorching"
};

app.MapGet("/weatherforecast", () =>
{
    var forecast =  Enumerable.Range(1, 5).Select(index =>
        new WeatherForecast
        (
            DateOnly.FromDateTime(DateTime.Now.AddDays(index)),
            Random.Shared.Next(-20, 55),
            summaries[Random.Shared.Next(summaries.Length)]
        ))
        .ToArray();
    return forecast;
})
.WithName("GetWeatherForecast");

// Esto es necesario para que los controladores funcionen
app.MapControllers();

app.Run();

record WeatherForecast(DateOnly Date, int TemperatureC, string? Summary)
{
    public int TemperatureF => 32 + (int)(TemperatureC / 0.5556);
}