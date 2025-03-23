window.modalHandlers['cartaceo']={
    change:function(){
        refresh({
            data:document.querySelector('#data').value
        });
    },
    removeDay:function(){
        const dataInput = document.querySelector('#data');
        const currentDate = new Date(dataInput.value);
        currentDate.setDate(currentDate.getDate() + -1);
        dataInput.value = currentDate.toISOString().split('T')[0];
        this.change();
    },
    addDay:function(){
        const dataInput = document.querySelector('#data');
        const currentDate = new Date(dataInput.value);
        currentDate.setDate(currentDate.getDate() + 1);
        dataInput.value = currentDate.toISOString().split('T')[0];
        this.change();
    },
    printTable:function () {
        const dateValue = document.querySelector('#data').value;
        const real_date = new Date(dateValue);
        const formattedDate = real_date.toLocaleDateString('en-GB');
        let table = document.querySelector('.table').outerHTML;
        let date = document.querySelector('#date-label').innerHTML +' '+ formattedDate;
        let newWin = window.open('', '', 'width=800,height=600');
        newWin.document.write(`
            <html>
                <head>
                    <style>
                        @page {
                            size: A4 landscape;
                            margin: 10mm;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 10px;
                            text-align:center;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            text-align:center;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 3px;
                            text-align: left;
                            height: 30px;
                            white-space: nowrap;
                            text-align:center;
                        }
                        th {
                            background-color: #f2f2f2;
                            text-align:center;
                        }
                        tr {
                            min-height: 30px;
                        }
                        @media print {
                            body {
                                zoom: 95%;
                            }
                            table {
                                page-break-inside: avoid;
                            },
                            .no-print {
                                display: none;
                            }
                        }
                    </style>
                </head>
                <body>
                    <h3 style="width:100%;text-align:center;margin-botton;5px;">${date}</h3>
                    ${table}
                    <script>
                        window.onload = function() {
                            window.print();
                            window.onafterprint = function() { window.close(); };
                        };
                    </script>
                </body>
            </html>
        `);
        newWin.document.close();
    }
    
};