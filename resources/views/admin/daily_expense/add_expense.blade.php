@extends('admin.master')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <form onsubmit="expense_add(event)" id="expense_add_form" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Basic Layout</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>

                    <div class="card-body">
                        <div id="date_row" class="row mb-3 align-items-center">
                            <div class="col-md-6  d-flex align-items-center justify-content-center">
                                <label class="form-label" for="bajar_date" style="width: 30%">Bajar Date</label>
                                <input type="date" name="bajar_date" class="form-control" placeholder="Bajar Date" />
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="badge  bg-label-success rounded" onclick="add_row()">
                                    <i class="fas fa-plus ti-sm"></i>
                                </div>
                            </div>
                        </div>

                        <div id="bajar_body">
                            {{-- row insert here --}}
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('end_js')
    <script>
        // JavaScript to calculate total based on price and quantity
        // document.getElementById('price').addEventListener('input', updateTotal);
        // document.getElementById('quantity').addEventListener('input', updateTotal);
        let add_id = 1;
        let i = 0;
        function add_row(){
            // console.log("some");
            let bajar_body =$('#bajar_body');
            // console.log("bajar_body");
            bajar_body.append(
                `
                <div class="row mb-2 row_no_${add_id}" data-id='${i}'>
                    <div class="col-4" data-field='title' >
                        <input type="text" name="bajar[${i}][title]" class="form-control title" placeholder="Title" />
                    </div>
                    <div class="col-1" data-field='quantity'>
                        <input type="text" name="bajar[${i}][quantity]"  class="quantity form-control" placeholder="qty" />
                    </div>
                    <div class="col-2" data-field='unit'>
                            <select class="form-select select2 unit_select unit" name="bajar[${i}][unit]" >
                                <option value="" selected>Select a unit</option>
                                <option value="kg">KG</option>
                                <option value="pcs">PCS</option>
                                <option value="gm">GM</option>
                            </select>
                    </div>
                    <div class="col-2" data-field='price'>
                        <input type="text" name="bajar[${i}][price]"  class="price form-control" placeholder="Price" />
                    </div>
                    <div class="col-2" data-field='total'>
                        <input type="text" name="bajar[${i}][total]"  class="total form-control" placeholder="Total" readonly />
                    </div>
                    <div class="col-1 d-flex align-item-center justify-content-evenly gap-2">
                        <div class="badge  bg-label-danger rounded" onclick="delete_row('row_no_${add_id}')">
                            <i class="fas fa-trash-alt ti-sm"></i>
                        </div>
                    </div>
                </div>
                `
            )
            $('.unit_select').select2();
            add_id++
            i++


            const priceInputs = document.querySelectorAll('.price');
            const quantityInputs = document.querySelectorAll('.quantity');
            const totalInputs = document.querySelectorAll('.total');

            priceInputs.forEach((priceInput, index) => {
                priceInput.addEventListener('input', () => updateTotal(index));
            });

            quantityInputs.forEach((quantityInput, index) => {
                quantityInput.addEventListener('input', () => updateTotal(index));
            });

            function updateTotal(index) {
                const price = parseFloat(priceInputs[index].value) || 0;
                const quantity = parseFloat(quantityInputs[index].value) || 0;
                const total = price * quantity;
                totalInputs[index].value = total;
                // console.log(total);
            }

    }
    function delete_row(className) {
        console.log(className);
        var elements = document.getElementsByClassName(className);
        if (elements.length > 0) {
            // Remove the first element with the specified class
            elements[0].remove();
        }
    }


    function expense_add(event) {
        event.preventDefault();
        console.log("expense_add clicked");

        let formData = new FormData(event.target);
        // console.log('formData:',formData);
        let isResponse = false;
        fetch('/daily_expense/store',{
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // console.log('formData in to the data:', formData);
                console.log("nothing in data");
                console.log('responce data: ',data);
                if(data){
                    let all_error = document.querySelectorAll(".error_block")
                    all_error.forEach(errorBlock => {
                        errorBlock.remove();
                    });
                    if (!data.data) {
                        console.log(data.message);
                        let date_row =document.getElementById('date_row');
                        let div =document.createElement('div');
                        div.style.color = 'red';
                        div.setAttribute('class','error_block')
                        div.innerHTML = `<P>${data.message}</P>`;
                        div.querySelector('p').style.margin = '0';
                        date_row.appendChild(div)
                    } else if(data.data.bajar_date != null){
                        // console.log(data.data.bajar);
                        // console.log(Object.keys(data.data.bajar).length);
                        error =data.data.bajar;
                        error_row_key = Object.keys(data.data.bajar);
                        // error_row_length = Object.keys(data.data.bajar).length;
                        // error_row_last_index = Object.keys(data.data.bajar)[error_row_length-1];
                        console.log(error_row_key);

                        error_row_key.forEach( function(value) {
                            console.log(value);
                            let error_row = document.querySelector(`[data-id='${value}']`)
                            // console.log(error_row);
                            // console.log(error[value]);
                            error[value].forEach(function(item) {
                                console.log(item.field);
                                error_block = document.createElement('div')
                                error_block.setAttribute('class','error_block col')
                                error_block.style.color = 'red';
                                error_block.innerHTML = `<P>${item.field} field is empty.</P>`;
                                error_block.querySelector('p').style.margin = '0';
                                error_row.appendChild(error_block)
                            })
                        })
                        // for(let i = 0; i <= error_row_last_index ; i++){
                        //     // console.log(i);
                        //     if()
                        // }

                    }else{
                        console.log("date is null");
                        let date_row =document.getElementById('date_row');
                        error_block = document.createElement('div')
                        error_block.setAttribute('class','error_block')
                        error_block.style.color = 'red';
                        error_block.innerHTML = `<P>Bajar date is empty. you have to set bajar date first</P>`;
                        error_block.querySelector('p').style.margin = '0';
                        date_row.appendChild(error_block)
                    }
                }
                isResponse = true;
            })
            .finally(() => {
                // Execute this code only if the .then block was not executed
                if (!isResponse) {
                    $('#bajar_body').remove();
                }
            });



    }


    // function expense_add(event) {
    //     let formData = new FormData(expense_add_form);
    //     console.log(formData);
    //     $.post("/daily_expense/store", function(data, status){
    //         alert("Data: " + data + "\nStatus: " + status);
    //     });
    // }




    </script>
@endpush
