let total = 0;
const selectedProducts = {};
let selectedCpuCategory = null;
const assemblyPrice = 35.90;
let assemblySelected = false;
const selectedMemories = [];
const selectedStorages = [];
let valor;
let valor2;
let i = 1;
let unidad = 1;
// Funci贸n para actualizar el precio total en la interfaz
function updateTotalPrice() {
    let finalTotal = total;
    if (assemblySelected) {
        finalTotal += assemblyPrice;
    }
    $('#total-price').text('S/ ' + finalTotal.toFixed(2));
}

// Funci贸n para cargar productos por categor铆a
function loadProducts(category, page = 1) {
    $.ajax({
        method: 'POST',
        url: `../public/ajax/ajs_products_assemble.php`,
        data: { tipo: 'cn', category: category, cpuCategory: selectedCpuCategory || '', page: page },
        dataType: 'json',
        success: function(data) {
            $('#product-list').html(data.html);
            initializeCheckboxes(category);
            restoreSelections(category);
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

// Evento para cambiar de categor铆a
$('.category-link').on('click', function(event) {
    event.preventDefault();
    const category = $(this).data('category');

    // Validar selecci贸n de procesador para la categor铆a 2
    if (category == 2 && selectedCpuCategory) {
        Swal.fire({
            title: 'Primero debes elegir un procesador',
            showDenyButton: true,
            confirmButtonText: 'Aceptar',
            denyButtonText: 'Tengo dudas',
        }).then((result) => {
            if (result.isDenied) {
                Swal.fire({
                    title: '驴Qu茅 es un procesador?',
                    html: `<p>Un procesador es el cerebro de la computadora. Es el componente que realiza las instrucciones de un programa inform谩tico mediante c谩lculos aritm茅ticos y l贸gicos.</p>
                           <p><strong>Intel</strong> y <strong>AMD</strong> son dos de los principales fabricantes de procesadores. Cada uno tiene sus propias arquitecturas y series de productos.</p>`,
                    confirmButtonText: 'Entendido'
                });
            }
        });
        return;
    }

    // Resetear selecci贸n de CPU cuando se cambia de categor铆a
    if (category !== 2) {
        selectedCpuCategory = null;
        $('.category-link[data-category="2"]').css('display', 'block');
    }

    loadProducts(category);
});

// Inicializar los checkboxes y manejar su l贸gica
function initializeCheckboxes(category) {
    $('.product-item .checkbox').off('change').on('change', function() {
        const productId = $(this).data('product-id');
        const productCategoryCpu = $(this).data('category-cpu');
        const productName = $(this).siblings('.product-info').find('div:first-child').text();
        const productImageSrc = $(this).siblings('img').attr('src');
        let productPrice = $(this).data('price');

        // Aseg煤rate de que el precio es una cadena
        if (typeof productPrice === 'number') {
            productPrice = productPrice.toFixed(2);
        } else if (typeof productPrice === 'string') {
            productPrice = productPrice.replace(',', '');
        } else {
            console.error('El precio no es una cadena ni un n煤mero:', productPrice);
            return;
        }
        
        productPrice = parseFloat(productPrice);

        // Limitar la selecci贸n de memorias RAM a 4
        if (category == 4) {
		
            if ($(this).is(':checked')) {
                if (selectedMemories.length >= 4) {
                    $(this).prop('checked', false).trigger('change');
                    return;
                }
		    
		
	          valor = prompt("Por favor, ingrese la cantidad:");

        	if (valor !== null && valor>0) {
               if (!isNaN(valor) && !isNaN(parseFloat(valor)) && parseInt(valor) == parseFloat(valor)) {
                   //alert("Gracias por ingresar un valor entero v醠ido");
	             
			      valor = parseInt(valor);
    				selectedMemories.push({ id: productId, price: productPrice, name: productName, image: productImageSrc, amount: valor });
	                  total += productPrice * valor;
   				i++; 

                    	} else {
		           alert("Por favor, ingrese solo n鷐eros enteros. ");
            	  	}
      	  } else {
           		console.log("Operaci髇 cancelada");
	            return null;
	        }
    		



        //        selectedMemories.push({ id: productId, price: productPrice, name: productName, image: productImageSrc });
        //        total += productPrice;
            } else {
                const index = selectedMemories.findIndex(mem => mem.id === productId);
                const generosPorId = Object.fromEntries(selectedMemories.map(item => [item.id, item.amount]));
		    let cntM = generosPorId[productId];
                if (index > -1) {
                    selectedMemories.splice(index, 1);
                    total -= productPrice*cntM;
                }
            }
        }

        // Limitar la selecci贸n de dispositivos de almacenamiento a 2
        if (category == 3) {
            if ($(this).is(':checked')) {
                if (selectedStorages.length >= 2) {
                    $(this).prop('checked', false).trigger('change');
                    return;
                }
		 valor2 = prompt("Por favor, ingrese la cantidad:");

        	if (valor2 !== null && valor>0) {
			if (!isNaN(valor2) && !isNaN(parseFloat(valor2)) && parseInt(valor2) == parseFloat(valor2)) {
				valor2 = parseInt(valor2);
				selectedStorages.push({ id: productId, price: productPrice, name: productName, image: productImageSrc, amount: valor2 });
		               total += productPrice * valor2;
			} else {
	   		      alert("Por favor, ingrese solo n鷐eros enteros.");
			}
		 } else {
			console.log("Operaci髇 cancelada"); 
		 }
                //selectedStorages.push({ id: productId, price: productPrice, name: productName, image: productImageSrc, amount: unidad });
                //total += productPrice;
            } else {
                const index = selectedStorages.findIndex(stor => stor.id === productId);
 		    const discosPorId = Object.fromEntries(selectedStorages.map(item => [item.id, item.amount]));
		    let cntD = discosPorId[productId];

                if (index > -1) {
                    selectedStorages.splice(index, 1);
                    total -= productPrice * cntD;
                }
            }
        }

        // Manejar la l贸gica para la selecci贸n 煤nica en otras categor铆as
        if (category != 4 && category != 3) {
            if ($(this).is(':checked')) {
                // Desmarcar autom谩ticamente el producto previamente seleccionado en la misma categor铆a
                if (selectedProducts[category] && selectedProducts[category].productId !== productId) {
                    total -= selectedProducts[category].price;
                    $(`.product-item .checkbox[data-product-id="${selectedProducts[category].productId}"]`).prop('checked', false).trigger('change');
                }
                selectedProducts[category] = { productId: productId, price: productPrice, name: productName, image: productImageSrc, amount: unidad };
                total += productPrice;
                displaySelectedProduct(category, productName, productPrice, productImageSrc);
            } else {
                total -= selectedProducts[category]?.price || 0;
                delete selectedProducts[category];
                removeSelectedProductDisplay(category);
            }
        }

        // Calcular el precio total de las memorias RAM y los dispositivos de almacenamiento
        const memoryTotal = selectedMemories.reduce((sum, mem) => sum + mem.price, 0);
        const storageTotal = selectedStorages.reduce((sum, stor) => sum + stor.price, 0);
        total = total - memoryTotal - storageTotal; // Restar antes de sumar de nuevo
        total += memoryTotal + storageTotal;

        // Asegurarse de que el total no sea negativo
        if (total < 0) {
            total = 0;
        }

        updateTotalPrice();
        updateCategorySelection();
    });
}

// Mostrar el producto seleccionado en la interfaz
function displaySelectedProduct(category, name, price, imageSrc) {
    const selectedProductDiv = $(`#selected-product-${category}`);
    const categoryName = $(`.category-link[data-category="${category}"]`).text();
    selectedProductDiv.html(`
        <div class="selected-product-title">${categoryName}</div>
        <img src="${imageSrc}" alt="${name}">
        <div class="product-info">
            <div>${name}</div>
            <div>S/ ${price.toFixed(2)}</div>
        </div>
    `).css('display', 'flex');

    $(`.category-link[data-category="${category}"]`).css('display', 'none');

    selectedProductDiv.on('click', function() {
        loadProducts(category);
    });
}

// Ocultar el producto seleccionado
function removeSelectedProductDisplay(category) {
    const selectedProductDiv = $(`#selected-product-${category}`);
    selectedProductDiv.css('display', 'none').html('');

    $(`.category-link[data-category="${category}"]`).css('display', 'block');
}

// Restaurar las selecciones al cargar productos
function restoreSelections(category) {
    if (selectedProducts[category]) {
        const selectedProductId = selectedProducts[category].productId;
        const checkbox = $(`.product-item .checkbox[data-product-id="${selectedProductId}"]`);
        if (checkbox.length) {
            checkbox.prop('checked', true);
            displaySelectedProduct(category, selectedProducts[category].name, selectedProducts[category].price, selectedProducts[category].image);
        }
    }

    // Restaurar las memorias RAM
    if (category == 4) {
        selectedMemories.forEach(memory => {
            const checkbox = $(`.product-item .checkbox[data-product-id="${memory.id}"]`);
            if (checkbox.length) {
                checkbox.prop('checked', true);
                displaySelectedProduct(category, memory.name || '', memory.price, memory.image || ''); // Nombre e imagen opcionales
            }
        });
    }

    // Restaurar los dispositivos de almacenamiento
    if (category == 3) {
        selectedStorages.forEach(storage => {
            const checkbox = $(`.product-item .checkbox[data-product-id="${storage.id}"]`);
            if (checkbox.length) {
                checkbox.prop('checked', true);
                displaySelectedProduct(category, storage.name || '', storage.price, storage.image || ''); // Nombre e imagen opcionales
            }
        });
    }
}

// Actualizar la selecci贸n de categor铆as
function updateCategorySelection() {
    $('.category-link').each(function() {
        const category = $(this).data('category');
        if (selectedProducts[category] || (category == 4 && selectedMemories.length > 0) || (category == 3 && selectedStorages.length > 0)) {
            $(this).addClass('selected');
        } else {
            $(this).removeClass('selected');
        }
    });
}

// Selecci贸n de ensamblaje
$('.category-link[data-category="1"]').on('click', function() {
    if (!assemblySelected) {
        Swal.fire({
            title: 'Confirmar selecci贸n de ensamblaje',
            text: `驴Deseas agregar el costo del ensamblaje de S/ ${assemblyPrice.toFixed(2)}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'S铆',
            cancelButtonText: 'No'
        }).then(result => {
            if (result.isConfirmed) {
                assemblySelected = true;
                total += assemblyPrice;
                updateTotalPrice();
                $(this).css('display', 'none');
            }
        });
    }
});

$('.form-cotizacion').click(function() {
    if (!checkMinimumCategoriesSelected(1)) {
        Swal.fire({
            title: 'Faltan categor铆as',
            html: 'Debe seleccionar al menos un producto en cada categor铆a antes de enviar la cotizaci贸n.',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    $('#cotizacionModal').modal('show');
});

// Enviar cotizaci贸n
$('.button.send-quotation').on('click', function(event) {
    $('#cotizacionModal').modal('hide');
    event.preventDefault();

    Swal.fire({
        title: 'Enviando cotizaci贸n...',
        text: 'Por favor, espera mientras enviamos tu cotizaci贸n al correo.',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const selectedProductsArray = Object.values(selectedProducts);
    const selectedMemoriesArray = selectedMemories;
    const selectedStoragesArray = selectedStorages;

    $.ajax({
        url: '../ajax/ajs_envio_coti.php',
        method: 'POST',
        data: {
            products: JSON.stringify({
                selectedProducts: selectedProductsArray,
                selectedMemories: selectedMemoriesArray,
                selectedStorages: selectedStoragesArray
            }),
            assembly: assemblySelected,
            tipo: 'en',
            nombre: $('#nombre').val(),
            email: $('#email').val()
        },
        dataType: 'json',
        success: function(data) {
            Swal.close();
            Swal.fire({
                title: '隆Cotizaci贸n enviada!',
                html: 'Tu cotizaci贸n ha sido enviada a tu correo electr贸nico.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        error: function(error) {
            Swal.close();
            Swal.fire({
                title: '隆Cotizaci贸n enviada!',
                html: 'Tu cotizaci贸n ha sido enviada a tu correo electr贸nico.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    });
});

$('#btnImprimircoti').on('click', function(event) {
    
    event.preventDefault();
    const selectedProductsArray = Object.values(selectedProducts);
    const selectedMemoriesArray = selectedMemories;
    const selectedStoragesArray = selectedStorages;
    const nombre = $('#nombre').val();
	
   
   let products = JSON.stringify({
                selectedProducts: selectedProductsArray,
                selectedMemories: selectedMemoriesArray,
                selectedStorages: selectedStoragesArray
    });

    let idpro = btoa(products);		
    ruta ='../CYM/arma-tu-pc-2.php?id='+idpro+'&data='+products;
    window.open(ruta, '_blank');

    
});



function checkMinimumCategoriesSelected(minCategories) {
    let count = 0;
    $('.category-link').each(function() {
        const category = $(this).data('category');
        if ((selectedProducts[category] && category !== 4 && category !== 3) || 
            (category == 4 && selectedMemories.length > 0) || 
            (category == 3 && selectedStorages.length > 0)) {
            count++;
        }
    });
    return count >= minCategories;
}


$(window).on('load', function() {
    loadProducts('001');
});