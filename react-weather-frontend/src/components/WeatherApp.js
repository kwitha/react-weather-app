import React, { useState } from "react";
import { fetchWeather } from "../api";
import "./WeatherApp.css";

const WeatherApp = () => {
  const [city, setCity] = useState("");
  const [weather, setWeather] = useState(null);
  const [forecast, setForecast] = useState([]);
  const [error, setError] = useState("");

  const handleSearch = async () => {
    setError("");
    setWeather(null);
    setForecast([]);
    if (!city) return;

    try {
      const data = await fetchWeather(city);
      if (data.cod && data.cod !== 200) {
        setError("City not found or API error");
      } else {
        setWeather(data);
        setForecast(data.forecast || []);
      }
    } catch (err) {
      setError("City not found or API error");
      console.error(err);
    }
  };

  return (
    <div className="weather-app">
      <h1>🌤 Weather Dashboard</h1>
      <input
        type="text"
        placeholder="Enter city"
        value={city}
        onChange={(e) => setCity(e.target.value)}
      />
      <button onClick={handleSearch}>Search</button>

      {error && <p className="error">{error}</p>}

      {weather && (
        <div className="current-weather">
          <h2>{weather.name}</h2>
          <p>Temperature: {weather.main.temp}°C</p>
          <p>Weather: {weather.weather[0].description}</p>
        </div>
      )}

      {forecast.length > 0 && (
        <div className="forecast">
          <h3>Forecast:</h3>
          <ul>
            {forecast.map((item, index) => (
              <li key={index}>
                {item.dt_txt}: {item.main.temp}°C, {item.weather[0].description}
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
};

export default WeatherApp;