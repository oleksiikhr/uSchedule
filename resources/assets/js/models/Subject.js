class Subject{

    static all(then, page = 1){
        return axios.get('/api/subjects.all?page=' + page)
            .then(({data}) => then(data));
    }

}

export default Subject;