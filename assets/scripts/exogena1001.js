// var empresa=document.getElementById('nombreEmpresa').value;
// var logo=document.getElementById('logoEmpresa').value;
// var nit=document.getElementById('nitEmpresa').value;
// var email=document.getElementById('emailEmpresa').value;
// var telefono=document.getElementById('telefonoEmpresa').value;
// var url=document.getElementById('url').value;

// var numero=document.getElementById('numero').value;
// var fecha=document.getElementById('fecha').value;

// var tipo=document.getElementById('tipo').value;
// var comprobante=document.getElementById('comprobante').value;
$(document).ready(function() {
    var table= $('#tableEnterprise').DataTable( {
        paging: false,
        ordering: false,
        dom: 'Blrtip',
        buttons: [

            // {
            // extend: 'copyHtml5',
            // text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
            // className: 'botoncopiar',
            // titleAttr: 'COPIAR'
            // },
            {
            extend: 'excel',
            footer: false,
            // title: 'EXC1003',
            filename: 'EXC1001',
            text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            titleAttr: 'EXCEL',
            insertCells: [                  // Add an insertCells config option 
                // {
                //     cells: 'sCh',               // Target the header with smart selection
                //     content: 'New column C',    // New content for the cells
                //     pushCol: true,              // pushCol causes the column to be inserted
                // },
                // {
                //     cells: 'sC1:C-0',           // Target the data
                //     content: '',                // Add empty content
                //     pushCol: true               // push the columns to the right over one
                // },
                {
                    cells: 's0:3',              // Target data row 5 and 6
                    content: '',                // Add empty content
                    pushRow: true               // push the rows down to insert the content
                },
                
                // {
                //     cells: 'B2',                // Target cell B3
                //     content: 'THIS IS CELL B3', // without pushCol or pushRow defined, the cell
                //                                 // is overwritten
                // },
                {
                    cells: 'A1:C1',                // Target cell B3
                    content: 'SmartBuss - Asegurarte', // without pushCol or pushRow defined, the cell
                                                // is overwritten
                },
                // {
                //     cells: 'C2',
                //                   // Target cell B3
                //     content: '', // without pushCol or pushRow defined, the cell
                //                                 // is overwritten
                // },
                {
                    cells: 'D2',
                                  // Target cell B3
                    content: 'DATOS DE INFORMACION', // without pushCol or pushRow defined, the cell
                                                // is overwritten
                },
                {
                    cells: 'E2',
                                  // Target cell B3
                    content: 'EXOGENA FORMATO', // without pushCol or pushRow defined, the cell
                                                // is overwritten
                },
                {
                    cells: 'F2',
                                  // Target cell B3
                    content: '1001 AÑO 2021', // without pushCol or pushRow defined, the cell
                                                // is overwritten
                },
                // {
                //     cells: 'G2',
                //                   // Target cell B3
                //     content: '', // without pushCol or pushRow defined, the cell
                //                                 // is overwritten
                // },
            ],
            excelStyles: [
            {
                cells:"1",
                style:{
                    font:{
                        name:'Arial',
                        size:"10",
                        color:"FFFFFF",
                        b:true,
                    },
                    fill:{
                        pattern:{
                            color:'2993FC',
                        }
                    }
                }
            },
            {
                cells:"2:4",
                style:{
                    font:{
                        name:'Arial',
                        size:"13",
                        color:"FFFFFF",
                        b:true,
                    },
                    fill:{
                        pattern:{
                            color:'2993FC',
                        }
                    }
                }
            },
            {
                cells:"C2",
                style:{
                    alignment:{
                        horizontal: "right",
                    },
                    
                }
            },
            {
            cells:"6",
                style:{
                    font:{
                        name:'Arial',
                        size:"11",
                        color:"FFFFFF",
                        b:true,
                    },
                    fill:{
                        pattern:{
                            color:'2993FC',
                        }
                    }
                }
            },

        ]

            },

            
        ]
    } );

} );

$('[data-toggle="tooltip"]').tooltip();


