document.getElementById('tax-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Dummy tax rates for demonstration
    const provinceTaxRates = {
        'Province 1': 5,
        'Province 2': 6,
        'Bagmati Province': 25,
        'Gandaki Province': 5.5,
        'Lumbini Province': 6.5,
        'Karnali Province': 4,
        'Sudurpashchim Province': 4.5
    };
    
    const districtTaxRates = {
        'Kathmandu': 1.5,
        'Lalitpur': 1.2,
        'Bhaktapur': 5.75,
        'Chitwan': 1.3,
        'Pokhara': 1.4
    };

    // Get the values
    const province = document.getElementById('province').value;
    const district = document.getElementById('district').value;
    const taxableAmount = parseFloat(document.getElementById('taxable-amount').value);

    // Get the tax rates
    const provinceTaxRate = provinceTaxRates[province] || 0;
    const districtTaxRate = districtTaxRates[district] || 0;
    const totalTaxRate = provinceTaxRate + districtTaxRate;

    // Calculate the total tax amount
    const totalTaxAmount = (totalTaxRate / 100) * taxableAmount;

    // Update the HTML
    document.getElementById('total-rate').querySelector('h2').textContent = totalTaxRate.toFixed(2) + '%';
    document.getElementById('breakdown').innerHTML = `
        <div>Province Tax: ${provinceTaxRate.toFixed(2)}%</div>
        <div>District Tax: ${districtTaxRate.toFixed(2)}%</div>
    `;
    document.getElementById('calculated-tax').querySelector('h2').textContent = totalTaxAmount.toFixed(2);
});
