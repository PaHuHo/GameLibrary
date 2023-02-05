import axios from "axios";

export const INITIAL_CATEGORY=await getCategory();
export const INITIAL_GAME=await getGame();

export async  function getCategory(){
    const response = await axios.get("http://127.0.0.1:8000/api/category");

    return response.data
}
export async  function getGame(){
    const response = await axios.get("http://127.0.0.1:8000/api/game");
    return response.data
}