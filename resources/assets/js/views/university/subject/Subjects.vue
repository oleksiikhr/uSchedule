<template>
    <div class="md-flex-80">
        <md-table-card>
            <md-table md-sort="calories">
                <md-table-header>
                    <md-table-row>
                        <md-table-head md-sort-by="dessert">Предмет</md-table-head>
                        <md-table-head md-sort-by="calories" md-tooltip="The total amount of food energy and the given serving size">Курс</md-table-head>
                        <md-table-head md-sort-by="fat">Факультет</md-table-head>
                        <md-table-head md-sort-by="carbs">Тип</md-table-head>
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
                    md-size="10"
                    :md-total="total"
                    md-page="1"
                    md-label="Рядків"
                    md-separator="з"
                    :md-page-options="[10]"
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
                currentSize: 10,
                total: 0,
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

            onSelect(data) {
                this.selectedData = data;
                this.$forceUpdate();
            },

            getSubjects(page = 1){
                axios.get('/api/subjects.all?page=' + page)
                    .then(response => {
                        this.subjects = response.data.data;
                        this.total = response.data.total;
                    });
            }

        },
    }
</script>