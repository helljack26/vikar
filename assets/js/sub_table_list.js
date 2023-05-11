$(document).ready(function () {
    const resetCurrentBuyButton = (id) => {
        $("#table_product_buy" + id).text("Купити");
        $("#table_product_buy" + id).css({
            "background-color": "#8ec340",
            color: "white",
        });
    };

    //$(".price-all").text(parseFloat(12).toFixed(2));
    counts = parseInt($(".price-all").length);
    for (i = 0; i <= counts; i++) {
        text = $("#price" + i).text();
        $("#price" + i).text(parseFloat(text).toFixed(2));
    }

    $(".plus2").click(function (e) {
        var id = $(this).attr("id").slice(2); //id товара
        resetCurrentBuyButton(id);
        num = parseInt($("#val" + id).val()); //ко-во товара
        price = parseFloat($(".price" + id).html()); //цена товара
        num = num + 1; //плюсуємо нове ко-ство товара
        price_unit = $("#product_unit" + id).val(); //коефіциент
        new_price = parseFloat(price) + parseFloat(price_unit);
        $(".price" + id).html(new_price.toFixed(2)); //плюсуємо товар
        $("#val" + id).val(num); //заносимо нове ко-во товара
        return false;
    });

    $(".minus").click(function () {
        var id = $(this).attr("id").slice(3);
        resetCurrentBuyButton(id);
        num = parseInt($("#val" + id).val());
        num = num - 1; //ко-во
        price_unit = $("#product_unit" + id).val(); //коефіциент
        price = parseFloat($(".price" + id).html()); //цена товара
        if (num > 0) {
            new_price = parseFloat(price) - parseFloat(price_unit); //нова ціна товара
            $(".price" + id).html(new_price.toFixed(2)); //плюсуємо товар
            $("#val" + id).val(num);
        }
        return false;
    });
    $(".select_tb").change(function () {
        var num = $(this).attr("data");
        resetCurrentBuyButton(num);
        price = parseFloat($(".price" + num).html()); //цена товара
        price = $(this).val(); //коф
        col = parseInt($("#val" + num).val()); //ко-во товара
        new_price = parseFloat(price) * parseFloat(col);
        $(".price" + num).html(new_price.toFixed(2));
        return false;
    });
    $(".popup-stuff__count-value").on("keyup input", function () {
        var id = $(this).attr("id").slice(3);
        resetCurrentBuyButton(id);
        qount = parseInt($(this).val());
        price_unit = parseInt($("#product_unit" + id).val());
        res = qount * price_unit;
        $(".price" + id).html(res.toFixed(2));
    });

    //Buy button
    $(".table_buttons_row_basket").click(function (event) {
        var id = $(this).attr("data-code");

        if (event.target.innerText === "Оформити") {
            return (document.location = "my-cart.php");
        } else {
            var price = parseFloat($("#product_unit" + id).val());
            quant = parseInt($("#val" + id).val());
            unit = $("#product_unit" + id).val();
            product_code = event.target.attributes[2].value;

            const charHash = $(this).attr('data-char');
            const isCharHash = charHash.length > 0 ? charHash : '';

            const setTableButtonActiveState = () => {
                $(this).text("Оформити");
                $(this).css({
                    "background-color": "#679500",
                    color: "#ffcd00",
                });
            };
            $.ajax({
                type: "POST",
                url: "my-cart/my-cart-no-reload.php",
                data: {
                    price: price,
                    quant: quant,
                    unit: unit,
                    pid: product_code,
                    char_hash: isCharHash,
                },
                success: function (results) {
                    setTableButtonActiveState();
                    const data = results.split("|");
                    const countInBasket = data[0];
                    const sumInBasket = parseFloat(data[1]);
                    const newBasketData = data[2];

                    // Basket update
                    $(".header_second_row_basket_block").html(newBasketData);
                    $(".count").fadeIn();
                    $(".count").html(countInBasket);
                    $(".value").html(`${sumInBasket.toFixed(2)} ₴`);
                    $(".valuee").html(`${sumInBasket.toFixed(2)} ₴`);
                    $(".price_sum").html(`${sumInBasket.toFixed(2)} ₴`);
                },
            });
        }
    });
});