<template>
 <div class="md-flex-80">
  <md-table-card>
   <md-table md-sort="first_name" md-sort-type="asc" @sort="onSort">
    <md-table-header>
     <md-table-row>
      <md-table-head v-for="(column, index) in columns" :key="index" :md-sort-by="column.sortField">{{ column.name }}</md-table-head>
      <md-table-head width="100px"></md-table-head>
     </md-table-row>
    </md-table-header>

    <md-table-body>
     <md-table-row v-for="(row, index) in teachers" :key="index">
      <md-table-cell>{{ row.first_name }}</md-table-cell>
      <md-table-cell>{{ row.middle_name }}</md-table-cell>
      <md-table-cell>{{ row.last_name }}</md-table-cell>
      <md-table-cell>{{ row.academic_title }}</md-table-cell>
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
                teachers: [],
                currentPage: 1,
                currentSize: 20,
                total: 0,
                columns: [
                    { name: 'Имя', sortField: 'first_name' },
                    { name: 'Отчество', sortField: 'middle_name' },
                    { name: 'Фамилия', sortField: 'last_name' },
                    { name: 'Статус', sortField: 'academic_title' },
                ]
            }
        },

        created(){
            this.getTeachers();
        },

        methods: {
            onPagination (paging) {
                this.currentPage = paging.page;
                this.currentSize = paging.size;
                this.getTeachers(this.currentPage);
            },

            getTeachers(page = 1){
                axios.get('/api/teachers.all?page=' + page + '&perPage=' + this.currentSize)
                    .then(response => {
                        this.teachers = _.orderBy(response.data.data, ['first_name'], ['asc']);
                        this.total = response.data.total;
                    });
            },

            onSort(data){
                this.teachers = _.orderBy(this.teachers, [data.name], [data.type]);
            }
        },
    }
</script>