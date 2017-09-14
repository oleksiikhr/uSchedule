class Subject{

    static all(page = 1){
        let subjects = {};

        axios.get('/api/subjects.all?page=' + page)
            .then(response => {
                subjects = response.data;
            });

        return subjects;
    }

}

export default Subject;