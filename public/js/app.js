$(document).ready(function () {
    // Search Product
    $("#search").on("keyup", function () {
        $.ajax({
            url: "http://localhost/pos/public/pos/search",
            method: "POST",
            data: {
                search: $(this).val(),
            },
            success: function (data) {
                // console.log(data)
                $("#content").html(data);
                // const items = JSON.parse(data);
                // $("#list_transaction").empty();
            },
        });
    });

    // Reduce Cart Quantity
    $(".reduce").on("click", function () {
        const id = $(this).data("id");
        // console.log(id);
        $.ajax({
            url: "http://localhost/pos/public/pos/decrementcart",
            data: { id: id },
            method: "post",
            // dataType: 'json',
            success: function (data) {
                $(".qty").val(data);
                location.reload();
            },
        });
    });

    // Delete Cart
    $(".delete").on("click", function () {
        const id = $(this).data("id");
        // console.log(id);

        $.ajax({
            url: "http://localhost/pos/public/pos/delete",
            data: { id: id },
            method: "post",
            // dataType: 'json',
            success: function (data) {
                location.reload();
            },
        });
    });

    // User Payment
    $("#payment").on("input", function () {
        const payment = $("#payment").val();
        const total = $("#total").val();
        const receipt = payment - total;

        $("#paymentText").html(`Rp. ${rupiah(payment)}, 00`);
        $("#receipt").html(`Rp. ${rupiah(receipt)}, 00`);

        if (payment == null || payment == "") {
            $("#paymentText").html(`Rp. 0`);
            $("#receipt").html(`Rp. 0`);
        }

        if (receipt < 0) {
            $("#btnSave").attr("disabled", "disabled");
        } else {
            $("#btnSave").removeAttr("disabled");
        }
    });

    // Rupiah
    function rupiah(number) {
        const numberString = number.toString();
        const split = numberString.split(",");
        const receipt = split[0].length % 3;
        let rupiah = split[0].substr(0, receipt);
        const ribuan = split[0].substr(receipt).match(/\d{1,3}/gi);
        if (ribuan) {
            const separator = receipt ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        return split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    }

    // Get data form payment
    // $('#btnSave').on('click', function (e) {
    //     e.preventDefault();

    // })

    // Form Edit Data
    $(".edit_data").on("click", function () {
        $(".modal-body form").attr(
            "action",
            "http://localhost/pos/public/product/editdata"
        );
        $("#modalTitle").html("Edit Data");
        const id = $(this).data("id");

        $.ajax({
            url: "http://localhost/pos/public/product/getdata",
            data: { id: id },
            method: "POST",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#productnamemodal").val(data.name);
                $("#imgmodal").attr("src", "uploads/" + data.image);
                $("#descriptionmodal").val(data.description);
                $("#qtymodal").val(data.quantity);
                $("#pricemodal").val(data.price);
                $("#id").val(data.idproduct);
            },
        });
    });

    // $(".delete_data").on('click', function () {
    //     const id = $(this).data('id')
    //     $.ajax({
    //         url: 'http://localhost/pos/public/product/delete',
    //         data: { id: id },
    //         method: "post",
    //         // dataType: 'json',
    //         success: function (data) {
    //             // location.reload();
    //         }
    //     })
    // })

    // Details Modal
    $(".trans_details").on("click", function () {
        const id = $(this).data("id");
        $.ajax({
            url: "http://localhost/pos/public/transactions/getItem",
            data: { id: id },
            method: "post",
            // dataType: 'json',
            success: function (data) {
                const items = JSON.parse(data);
                $("#list_transaction").empty();
                for (const item in items) {
                    const subTotal =
                        parseInt(items[item].price) *
                        parseInt(items[item].quantity);
                    console.log(subTotal);
                    $("#list_transaction").append(
                        `<tr>
              <td>${items[item].name}</td>
              <td style="text-align:center">${items[item].quantity}</td>
              <td style="text-align:center">${items[item].price}</td>
              <td style="text-align:center">${subTotal}</td>
            </tr>`
                    );
                }
            },
        });
    });

    // Checked Multiple
    $("#delMultiple").on("click", function () {
        if ($(this).is(":checked")) {
            $(".checkMultiple").prop("checked", true);
        } else {
            $(".checkMultiple").prop("checked", false);
        }
    });

    // Delete selected
    $(".button_del").on("click", function (e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this data?")) {
            let id = [];
            $(".checkMultiple:checked").each(function (i) {
                id[i] = $(this).val();
            });
            if (id.length === 0) {
                alert("Choose at least one dataaaaaaaa");
            } else {
                $.ajax({
                    url: "http://localhost/pos/public/product/deletemultiple",
                    method: "POST",
                    data: { id: id },
                    success: function (data) {
                        location.reload();
                    },
                });
            }
        }
    });

    // active url
    let path = location.pathname.split("/");
    let url = location.origin + "/" + path[1] + "/" + path[2] + "/" + path[3];
    $("ul.navbar-nav li a").each(function () {
        if ($(this).attr("href").indexOf(url) !== -1) {
            $(this).addClass("active");
        }
    });
});
