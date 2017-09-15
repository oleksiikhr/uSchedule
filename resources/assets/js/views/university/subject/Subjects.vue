<template>
    <div class="md-flex-80">
        <md-table-card>
            <md-table md-sort="course" md-sort-type="asc" @sort="onSort">
                <md-table-header>
                    <md-table-row>
                        <md-table-head v-for="(column, index) in columns" :key="index" :md-sort-by="column.sortField">{{ column.name }}</md-table-head>
                        <md-table-head width="100px"></md-table-head>
                    </md-table-row>
                </md-table-header>

                <md-table-body>
                    <md-table-row v-for="(row, index) in subjects" :key="index">
                        <md-table-cell>{{ row.title }}</md-table-cell>
                        <md-table-cell>{{ row.course }}</md-table-cell>
                        <md-table-cell>{{ row.faculty_id.title }}</md-table-cell>
                        <md-table-cell>{{ row.type }}</md-table-cell>
                        <md-table-cell>
                            <md-button class="md-icon-button">
                                <md-icon>visibility</md-icon>
                            </md-button>
                            <md-button class="md-icon-button">
                                <md-icon>edit</md-icon>
                            </md-button>
                            <md-button class="md-icon-button">
                                <md-icon>delete</md-icon>
                            </md-button>
                        </md-table-cell>
                    </md-table-row>
                </md-table-body>
            </md-table>
            <md-table-pagination
                    :md-size="currentSize"
                    :md-total="total"
                    md-page="1"
                    md-label="Рядків"
                    md-separator="з"
                    :md-page-options="[20]"
                    @pagination="onPagination">
            </md-table-pagination>
        </md-table-card>
    </div>
</template>
<script>

    export default {
        data(){
            return {
                subjects: [],
                currentPage: 1,
                currentSize: 20,
                total: 0,
                columns: [
                    { name: 'Предмет', sortField: 'title' },
                    { name: 'Курс', sortField: 'course' },
                    { name: 'Факультет', sortField: 'faculty' },
                    { name: 'Тип', sortField: 'type' },
                ]
            }
        },

        created(){
            this.getSubjects();
        },

        methods: {
            onPagination (paging) {
                this.currentPage = paging.page;
                this.currentSize = paging.size;
                this.getSubjects(this.currentPage);
            },

            getSubjects(page = 1){
                axios.get('/api/subjects.all?page=' + page + '&' + this.currentSize)
                    .then(response => {
                        this.subjects = _.orderBy(response.data.data, ['course'], ['asc']);
                        this.total = response.data.total;
                    });
            },

            onSort(data){
                if(data.name === 'faculty'){
                    data.name = 'faculty_id.title';
                }
                this.subjects = _.orderBy(this.subjects, [data.name], [data.type]);
            }
        },
    }
</script>