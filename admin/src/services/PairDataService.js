import axiosInstance from "../utils";

class PairDataService {
    async getAll() {
        return (await axiosInstance.get('/pairs')).data;
    }
    async get(id) {
        return (await axiosInstance.get(`/pairs/${id}`)).data;
    }
    async create(data) {
        return (await axiosInstance.post("/pairs", data)).data;
    }
    async update(id, data) {
        return (await axiosInstance.put(`/pairs/${id}`, data)).data;
    }
    async delete(id) {
        return (await axiosInstance.delete(`/pairs/${id}`)).data;
    }
}
export default new PairDataService();
