<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perkara - Sistem Manajemen Perkara</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0d6efd',
                        secondary: '#6c757d',
                        success: '#198754',
                        info: '#0dcaf0',
                        warning: '#ffc107',
                        danger: '#dc3545',
                        light: '#f8f9fa',
                        dark: '#212529',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Custom utilities untuk status badge */
        .status-badge {
            display: inline-block;
            text-align: center;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            min-width: 110px;
        }
        
        /* Styling untuk tabel responsif */
        @media (max-width: 1024px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive table {
                min-width: 800px;
            }
            
            .stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }
        
        @media (max-width: 640px) {
            .stat-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
            
            .filter-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }
        
        /* Styling untuk row yang dapat diklik */
        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .clickable-row:hover {
            background-color: #f0f9ff !important;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased pb-8">

        <div>
        <!--sidebar wrapper -->
        @include('layouts.template')
        <!--end sidebar wrapper -->

        <!--start header -->
        <!--end header -->

        <!--start page wrapper -->
        @yield('content')
        <!--end page wrapper -->

    </div>



    <script>
        // Reset filters
        document.getElementById('resetFilters').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = "{{ route('perkaras.index') }}";
        });
        
        // Clickable rows
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
        
        // Prevent click when clicking on buttons inside the row
        document.querySelectorAll('.clickable-row a, .clickable-row button, .clickable-row form').forEach(element => {
            element.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // Auto submit form when filter changes
        document.querySelectorAll('select[name="status"], select[name="jenis_perkara"], select[name="keterangan_filter"], select[name="perPage"]').forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
        
        // Loading indicator for search
        document.getElementById('filterForm').addEventListener('submit', function() {
            const searchButton = document.getElementById('searchButton');
            searchButton.innerHTML = '<div class="loading-spinner"></div>';
            searchButton.disabled = true;
        });
        
        // Enter key to submit search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    </script>
</body>
</html>