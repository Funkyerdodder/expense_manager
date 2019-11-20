@extends('template.layout')

@section('content')
<h1>My Expenses</h1>

<v-container>
    <v-row>
        <v-col cols="6">
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <th class="text-left">Category</th>
                        <th class="text-left">Total</th>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.category_name">
                            <td>@{{ item.category_name }}</td>
                            <td>@{{ item.total }}</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-col>
        <v-col cols="4">
            <div class="chart" ref="pieChart"></div>
        </v-col>
    </v-row>
</v-container>


<script>
    var dashboard = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            items: [],
            chartData: [],
            chartLabel: []
        }),
        mounted: function() {
            this.getData();
        },
        methods: {
            getData() {
                
                this.$http.get("{{ url('/sumarize-expenses') }}")
                    .then(res => {
                        var chartData = [];
                        var chartLabael = [];
                        console.log(res);
                        this.items = res.body;
                        res.body.forEach(data => {
                            chartData.push(data.total)
                            chartLabael.push(data.category_name)
                        });
                        this.generateChart(chartData, chartLabael);
                    }, err => {

                    }
                )
            },
            generateChart(series, label) {
                new ApexCharts(this.$refs.pieChart, {
                    chart: {
                        type: 'pie',
                        height: 400
                    },
                    series: series,
                    labels: label
                }).render()
            }
        }
    })
</script>

@endsection