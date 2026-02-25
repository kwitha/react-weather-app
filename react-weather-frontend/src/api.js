import axios from "axios";

// Replace this with your Laravel backend URL
const BASE_URL = "http://127.0.0.1:8000/api";

export const fetchWeather = async (city) => {
  try {
    // Call your Laravel backend route
    const response = await axios.get(`${BASE_URL}/weather/current`, {
      params: { city },
    });
    
    const data = response.data;

    // For forecast, optionally you can fetch it here
    // const forecastResponse = await axios.get(`${BASE_URL}/weather/forecast`, { params: { city } });
    // data.forecast = forecastResponse.data.list;

    return data;
  } catch (error) {
    console.error("API error:", error);
    throw error;
  }
};