document.addEventListener("DOMContentLoaded", function() {

    axios.get('/website/project/Hakathon/API/Fetch/fetch_client.php')
        .then(response => {
            const clients = response.data;
            const clientSelect = document.getElementById('clientSelect');
            if (clients.length === 0) {
                alert('No clients found. Add a customer or company.');
            } else {
                clients.forEach(client => {
                    const option = document.createElement('option');
                    option.value = `${client.type}-${client.id}`;
                    option.textContent = `${client.name} (${client.type})`;
                    clientSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching clients:', error);
        });


    axios.get('/website/project/Hakathon/API/Fetch/fetch_product.php')
        .then(response => {
            const products = response.data;
            const productSelect = document.getElementById('productSelect');
            if (products.length === 0) {
                alert('No products found. Add product .');
            } else {
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.product_id;
                    option.textContent = product.productName;
                    option.dataset.price = product.productPrice; // Assuming the price is part of the response
                    productSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });

    document.getElementById('productSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.dataset.price;
        document.getElementById('rate').value = price || '';
    });
});

function calculateAmount() {
    const quantity = parseFloat(document.getElementById('quantityHours').value) || 0;
    const rate = parseFloat(document.getElementById('rate').value) || 0;
    const discountRate = parseFloat(document.getElementById('discount').value) || 0;

    const subtotal = quantity * rate;
    const discountAmount = (subtotal * discountRate) / 100;
    const discountedSubtotal = subtotal - discountAmount;
    const tax = discountedSubtotal * 0.13;
    const totalAmount = discountedSubtotal + tax;

    document.getElementById('subtotal').value = discountedSubtotal.toFixed(2);
    document.getElementById('tax').value = tax.toFixed(2);
    document.getElementById('amount').value = totalAmount.toFixed(2);
}
