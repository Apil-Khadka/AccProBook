document.addEventListener('DOMContentLoaded', () => {
    const todoForm = document.getElementById('todo-form');
    const todoInput = document.getElementById('todo-input');
    const todoList = document.getElementById('todo-list');
  
    todoForm.addEventListener('submit', (e) => {
        e.preventDefault();
        addTodo(todoInput.value);
        todoInput.value = '';
    });
  
    function addTodo(task) {
        const li = document.createElement('li');
        li.textContent = task;
  
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('delete');
        deleteButton.addEventListener('click', () => {
            li.remove();
        });
  
        li.appendChild(deleteButton);
        li.addEventListener('click', () => {
            li.classList.toggle('completed');
        });
  
        todoList.appendChild(li);
    }
  });
  
  /*line graph*/
  const ctx = document.getElementById('salesChart').getContext('2d');
  
  const salesData = {
      labels: ['Jul 17', 'Jul 18', 'Jul 25', 'Aug 01', 'Aug 08', 'Aug 15'],
      datasets: [{
          label: 'Sales',
          data: [0, 0, 100, 0, 600, 10],
          borderColor: 'green',
          borderWidth: 2,
          fill: false,
          tension: 0.1
      }]
  };
  
  const config = {
      type: 'line',
      data: salesData,
      options: {
          responsive: true,
          plugins: {
              legend: {
                  display: true,
                  labels: {
                      color: 'green'
                  }
              }
          },
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      callback: function(value) {
                          return '€' + value;
                      }
                  }
              }
          }
      }
  };
  
  const salesChart = new Chart(ctx, config);
  
  
  
  
  /*2nd*/
  // Example income data
  const incomeData = {
    openInvoices: 250,
    overdueInvoice: 70,
    paidLast30Days: 460,
    total: 780 // Total income for scaling the bars
  };
  
  // Function to set bar heights
  function setBarHeights(data) {
    const openBar = document.getElementById('openBar');
    const overdueBar = document.getElementById('overdueBar');
    const paidBar = document.getElementById('paidBar');
  
    const openHeight = (data.openInvoices / data.total) * 100;
    const overdueHeight = (data.overdueInvoice / data.total) * 100;
    const paidHeight = (data.paidLast30Days / data.total) * 100;
  
    openBar.style.height = openHeight + '%';
    overdueBar.style.height = overdueHeight + '%';
    paidBar.style.height = paidHeight + '%';
  }
  
  // Function to set income details
  function setIncomeDetails(data) {
    document.getElementById('openInvoices').innerText = `€${data.openInvoices}`;
    document.getElementById('overdueInvoice').innerText = `€${data.overdueInvoice}`;
    document.getElementById('paidLast30Days').innerText = `€${data.paidLast30Days}`;
  }
  
  // Initialize the chart
  function initIncomeChart() {
    setBarHeights(incomeData);
    setIncomeDetails(incomeData);
  }
  
  // Run the initialization
  document.addEventListener('DOMContentLoaded', initIncomeChart);
  
  
  
  
  
  
  
  
  
  
  
  
  