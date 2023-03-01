import axios from "axios";
import { API_URL } from '@/api';

export const INITIAL_CATEGORY= getCategory();
export const INITIAL_GAME= getGame();

export async  function getCategory(){
    
    //const response = await axios.get("http://127.0.0.1:8000/api/category");
    const response = await axios.get(`${API_URL}/api/category`);

    return response.data
}
export async  function getGame(){
    const response = await axios.get(`${API_URL}/api/game`);
    return response.data
}