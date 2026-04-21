# Inventory & Sales Management System

A full stack web application built with Laravel and MySQL for managing business inventory, processing sales, tracking stock levels, and generating printable invoices. 
Built for small to medium businesses needing a straightforward internal operations tool.

## Key Features

Authentication & User Management
	∙	Secure login with hashed passwords via Laravel Auth
	∙	Role-based access levels for different user types
	∙	Add, edit, and delete system users
	∙	Session-based authentication throughout


Stock Management
	∙	View full stock inventory sorted alphabetically
	∙	Add new stock items with name, unit price, and cost price
	∙	Update existing stock — quantity and pricing
	∙	Edit and delete stock records
	∙	Search stock by item name
	∙	Real-time stock level retrieval via AJAX


Checkout & Sales
	∙	Checkout interface listing all available stock items
	∙	Multi-item checkout — select items and quantities in one transaction
	∙	Automatic stock deduction on checkout confirmation
	∙	Total calculation before confirming sale
	∙	Sales recorded with date, user, total selling price, and cost price


Invoice Generation
	∙	Printable invoice generated per transaction
	∙	Itemised breakdown — item name, quantity, unit price, line total
	∙	Sale date and grand total included


Sales Records & Reporting
	∙	Full sales history with date, total, cost price, and profit
	∙	Filter sales records by date range
	∙	Subtotal calculation across filtered records showing total revenue and profit


Low Stock Alerts
	∙	Automatic detection of items falling below stock threshold
	∙	Alert notifications for new low stock events
	∙	Dismiss alerts once reviewed
	∙	Alert badge showing count of unread notifications


Dashboard
	∙	Overview on login showing key operational summary

## Tech Stack
	∙	Backend — PHP, Laravel
	∙	Frontend — Blade, Bootstrap, JavaScript, AJAX
	∙	Database — MySQL
	∙	Auth — Laravel Auth with bcrypt password hashing

## Database Structure
Four core tables:
	∙	users — system users with access levels and hashed credentials
	∙	stock — inventory items with current stock, unit price, and cost price
	∙	sales — completed transactions with total, cost, date, and user
	∙	messages — low stock alert records linked to stock items

## Setup
Requirements
	∙	PHP 8+
	∙	Composer
	∙	MySQL

## Notes
	∙	Built as a complete internal business operations tool covering the full sales and inventory workflow
	∙	Invoice generation outputs a print-ready view per transaction
	∙	Low stock alerts are generated automatically when stock falls below threshold — no manual monitoring required
	∙	All passwords stored as bcrypt hashes via Laravel’s Hash facade
	∙	Built and tested with Laravel 10

## Author
Glenn Ansah — Full Stack Software Developer
	∙	Email: ansahglenn@gmail.com
	∙	GitHub: github.com/nanaglenn

