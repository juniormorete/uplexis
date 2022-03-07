const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary mr-3',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
})

$(document).ready(() => {

    var oDT = $('.dataTable').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        order: [],
        responsive: true,
        fixedHeader: true,
        scrollCollapse: true,
        buttons: [
            "copy", "excel", "pdf", "print", "colvis"
        ],
        language: {
            decimal: "",
            emptyTable: "Nenhum registro encontrado",
            info: "Exibindo <b>_START_ a _END_</b> registros / Total de <b>_TOTAL_</b>",
            infoEmpty: "Não há registros a serem exibidos",
            infoFiltered: "(filtro aplicado a _MAX_ registros)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Exibindo _MENU_ registros",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Pesquisar:",
            zeroRecords: "Nenhum resultado encontrado",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            },
            buttons: {
                copy: "<i class=\"far fa-copy\"></i> Copiar",
                csv: "<i class=\"fas fa-file-csv\"></i> CSV",
                excel: "<i class=\"far fa-file-excel\"></i> Excel",
                pdf: "<i class=\"far fa-file-pdf\"></i> PDF",
                print: "<i class=\"fas fa-print\"></i> Imprimir",
                colvis: "<i class=\"fas fa-columns\"></i> Colunas",
                copyTitle: "Área de Transferência",
                copySuccess: {
                    1: "Uma linha copiada com sucesso",
                    _: " % d linhas copiadas com sucesso"
                },
                copyKeys: "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc.."
            },
            aria: {
                sortAscending: ": ordenação crescente",
                sortDescending: ": ordenação decrescente"
            }
        }
    });

    $('.btnDelete').on('click', function () {
        if ($(this).hasClass('disabled'))
            return;

        let idCarro = $(this).data('id');

        swalWithBootstrapButtons.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja excluir o registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Sim',
            cancelButtonText: '<i class="fas fa-times"></i> Não'
        }).then((result) => {
            if (result.value) {
                $(".btnDelete[data-id='" + idCarro + "']").addClass('disabled').find('i').attr('class', 'fas fa-spin fa-spinner');

                $.ajax({
                    url: 'excluir',
                    type: "DELETE",
                    async: true,
                    data: {
                        _token: $("[name='_token']").val(),
                        id: idCarro
                    }
                })
                    .done(function (response) {
                        if ("OK" !== response?.sts) {
                            $(".btnDelete[data-id='" + idCarro + "']").removeClass('disabled').find('i').attr('class', 'fas fa-trash-alt');

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response?.message ?? 'Houve uma falha na comunicação com o servidor',
                                confirmButtonColor: '#d33'
                            });
                            return;
                        }

                        $(document).Toasts('create', {
                            title: 'Operação Concluída',
                            body: 'Registro excluído com sucesso',
                            icon: 'fas fa-check',
                            autohide: true,
                            delay: 5000
                        });

                        oDT.row($('#tr_' + idCarro)).remove().draw();
                    }).fail(function (response) {
                        $(".btnDelete[data-id='" + idCarro + "']").removeClass('disabled').find('i').attr('class', 'fas fa-trash-alt');

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response?.message ?? 'Houve uma falha na comunicação com o servidor',
                            confirmButtonColor: '#d33'
                        });
                    });
            }
        })
    });
});