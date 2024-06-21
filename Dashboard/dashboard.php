<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
  <link rel="stylesheet" href="./dashboard.css">


    <link rel="stylesheet" href="../Sidebar/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body id="body-pd">
<?php
include_once("../Sidebar/sidebar.html");
?>

    <div class="main-container">
    <div class="column-1">
        <div class="graph-row-1"><img class="graph-ss" src="./images/graph.jpeg"></div>

        <div class="graph-row-2">
            <div class="pie">
              <style>
                body {
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    background-color: #f5f5f5;
                }
                .widget {
                    background: #fff;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    width: 350px;
                    
                    padding: 50px;
                    box-sizing: border-box;
                }
                .widget h2 {
                    margin: 0;
                    font-size: 15px;
                    color: #333;
                }
                .widget .last-30-days {
                    float: right;
                    font-size: 11px;
                    color: #999;
                }
                .widget .total-expenses {
                  
                    font-size: 11px;
                    margin: 3px 0;
                    color: #333;
                }
                .widget .description {
                    font-size: 11px;
                    color: #666;
                    margin-bottom:2px;
                    padding-bottom:2px;
                }
                .widget .expense-item {
                    display: flex;
                    align-items: center;
                    margin-bottom: 6px;
                }
                .widget .expense-item .color-indicator {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin-right: 10px;
                }
                .widget .expense-item .expense-label {
                    font-size: 10px;
                    color: #333;
                  
                }
                .widget canvas {
                    display: block;
                    margin: 0 auto;
                }
            </style>
      
            <body>
            <div class="widget">
                <h2>EXPENSES <span class="last-30-days">Last 30 days ▼</span></h2>
                <div class="total-expenses">Rs.1,00,000</div>
                <div class="description">Total expenses</div>
                <div class="expense-item">
                    <div class="color-indicator" style="background: #00bcd4;"></div>
                    <div class="expense-label">Rs.50,000 Equipment rental</div>
                </div>
                <div class="expense-item">
                    <div class="color-indicator" style="background: #004d4d;"></div>
                    <div class="expense-label">Rs.10,000 Bank charges</div>
                </div>
                <canvas id="donutChart" width="200" height="200"></canvas>
            </div>
            <script>
                const canvas = document.getElementById('donutChart');
                const ctx = canvas.getContext('2d');
            
                const data = [30, 20];
                const colors = ['#00bcd4', '#004d4d'];
            
                let total = data.reduce((sum, value) => sum + value, 0);
                let startAngle = -0.5 * Math.PI;  // Start from the top
            
                data.forEach((value, index) => {
                    let sliceAngle = (value / total) * 2 * Math.PI;
                    ctx.beginPath();
                    ctx.moveTo(100, 100); // Center of the donut
                    ctx.arc(100, 100, 80, startAngle, startAngle + sliceAngle);
                    ctx.closePath();
                    ctx.fillStyle = colors[index];
                    ctx.fill();
                    startAngle += sliceAngle;
                });
            
                // Draw inner circle for donut effect
                ctx.beginPath();
                ctx.arc(100, 100, 50, 0, 2 * Math.PI);
                ctx.fillStyle = '#fff';
                ctx.fill();
            </script>
</div>
   <?php 
   include_once("../Sidebar/sidebar.html");
?>

            <div class="pie">
            <div class="income-chart">
              <h1>INCOME</h1>
             
              <div class="bar-container">
                  <div class="bar open" style="height: 45%;"></div>
                  <div class="bar overdue" style="height: 14%;"></div>
                  <div class="bar paid" style="height: 41%;"></div>
              </div>
              <div class="details">
                 <p class="invoice-type"><strong>Rs.2,50,000</strong><p class="invoice-type1">OPEN INVOICES</p> </p>
                 <p class="invoice-type"><strong>Rs.50,000</strong><p class="invoice-type1">OVERDUE INVOICE</p> </p>
                 <p class="invoice-type"><strong>Rs.1,00,000</strong><p class="invoice-type">OVERDUE INVOICE PAID LAST 30 DAYS</p> </p>
              </div>
          </div></div>
        </div>
    </div>

    <div class="todo-final">
      <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            
            justify-content: center;
           
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        
        .todo-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            box-sizing: border-box;
        }
        .todo-container h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .todo-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .todo-button {
            width: 100%;
            padding: 10px;
            background-color:#181e72;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .todo-button:hover {
            opacity:0.85;
        }

        .todo-button:active {
            opacity:0.75;
        }
        .todo-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .todo-item:last-child {
            border-bottom: none;
        }
        .delete-button {
            background: none;
            border: none;
            color: rgb(70, 62, 62);
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    </head>
    <body>
    <div class="todo-container">
        <h2 style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        padding-bottom:8px;
        padding-top:10px">To-Do List</h2>
        <input type="text" id="todoInput" class="todo-input" placeholder="Enter a new task">
        <button onclick="addTodo()" class="todo-button">Add Task</button>
        <ul id="todoList" class="todo-list"></ul>
    </div>
    <script>
        function addTodo() {
            const todoInput = document.getElementById('todoInput');
            const todoText = todoInput.value.trim();
            
            if (todoText !== '') {
                const todoList = document.getElementById('todoList');
                const listItem = document.createElement('li');
                listItem.className = 'todo-item';
                listItem.innerHTML = `
                    <span>${todoText}</span>
                    <button onclick="deleteTodo(this)" class="delete-button">X</button>
                `;
                todoList.appendChild(listItem);
                todoInput.value = '';
            }
        }
    
        function deleteTodo(button) {
            const listItem = button.parentElement;
            listItem.remove();
        }
    
        document.getElementById('todoInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                addTodo();
            }
        });
    </script>
    </div>
<script src="scripts.js"></script>
<script src="../Sidebar/main.js"></script>
</body>
</html>