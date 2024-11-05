import axios from 'axios';

const ProductApi = () => {};

ProductApi.index = async () => {
    const url = 'http://127.0.0.1:8000/api/product/';
    const res = await axios.get(url)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            return error;
        });
    return res;
};

ProductApi.save = async (data) => {
    let url = 'http://127.0.0.1:8000/api/product/';
    if (data.id) url = 'http://127.0.0.1:8000/api/product/' + data.id + '?_method=PUT';
    const res = await axios.post(url, data)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            return error;
        });
    return res;
};

ProductApi.show = async (id) => {
    const url = 'http://127.0.0.1:8000/api/product/' + id;
    const res = await axios.get(url)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            return error;
        });
    return res;
};

ProductApi.delete = async (id) => {
    const url = 'http://127.0.0.1:8000/api/product/' + id;
    const res = await axios.delete(url)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            return error;
        })
    return res;
};

export default ProductApi;