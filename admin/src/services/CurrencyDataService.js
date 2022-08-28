import axiosInstance from "../utils";

class CurrencyDataService {
    async getAll() {
        return (await axiosInstance.get('/currencies')).data;
    }
    async get(id) {
        return (await axiosInstance.get(`/currencies/${id}`)).data;
    }
    async create(data) {
        return (await axiosInstance.post("/currencies", data)).data;
    }
    async update(id, data) {
        return (await axiosInstance.put(`/currencies/${id}`, data)).data;
    }
    async delete(id) {
        return (await axiosInstance.delete(`/currencies/${id}`)).data;
    }
}
export default new CurrencyDataService();
