<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">CRUD Management</h1>
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Create Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Add New Entry</h2>
            <form action="{{route('crudcreate')}}" method="POST" class="flex gap-3">
                @csrf
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Enter name..."
                    required
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition"
                >
                    Create
                </button>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($data as $user )
                        {{$user->$id}}
                    @endforeach
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">1</td>
                        <td class="px-6 py-4 text-sm font-medium">Sample Entry</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ date('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-2 text-sm">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Empty State -->
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No entries yet. Create your first one!
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
















{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
        }
        
        .table-row {
            transition: all 0.3s ease;
        }
        
        .table-row:hover {
            background-color: #f8f9ff;
            transform: translateX(5px);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header with Gradient -->
    <div class="gradient-bg text-white py-8 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2 flex items-center gap-3">
                        <i class="fas fa-database"></i>
                        CRUD Management System
                    </h1>
                    <p class="text-indigo-100 text-lg">Create, Read, Update, and Delete your data efficiently</p>
                </div>
                <div class="badge bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                    <i class="fas fa-circle text-green-300 text-xs mr-2"></i>
                    <span class="font-semibold">Active</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg fade-in" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <div>
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg fade-in" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                <div>
                    <p class="font-bold">Oops! There were some errors:</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Create Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl card-shadow p-8 fade-in sticky top-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Add New Entry</h2>
                    </div>
                    
                    <form action="{{route('crudcreate')}}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-indigo-500"></i>Entry Name
                            </label>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                placeholder="Enter a name..."
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none input-focus text-gray-800 font-medium"
                            >
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full btn-gradient text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center gap-2 shadow-lg"
                        >
                            <i class="fas fa-paper-plane"></i>
                            Create Entry
                        </button>
                    </form>
                    
                    <!-- Stats Card -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-indigo-50 p-4 rounded-xl text-center">
                                <i class="fas fa-list text-indigo-600 text-2xl mb-2"></i>
                                <p class="text-2xl font-bold text-indigo-600">0</p>
                                <p class="text-xs text-gray-600 font-medium">Total Entries</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-xl text-center">
                                <i class="fas fa-clock text-purple-600 text-2xl mb-2"></i>
                                <p class="text-2xl font-bold text-purple-600">{{ date('H:i') }}</p>
                                <p class="text-xs text-gray-600 font-medium">Current Time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-white">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-table text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">Data Records</h2>
                                    <p class="text-indigo-100 text-sm">View and manage all entries</p>
                                </div>
                            </div>
                            <button class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                                <i class="fas fa-sync-alt"></i>
                                Refresh
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input 
                                    type="text" 
                                    placeholder="Search entries..." 
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none"
                                >
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="text-left py-4 px-4 text-gray-700 font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-2 text-indigo-500"></i>ID
                                        </th>
                                        <th class="text-left py-4 px-4 text-gray-700 font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-user mr-2 text-indigo-500"></i>Name
                                        </th>
                                        <th class="text-left py-4 px-4 text-gray-700 font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-2 text-indigo-500"></i>Created
                                        </th>
                                        <th class="text-center py-4 px-4 text-gray-700 font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-cog mr-2 text-indigo-500"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <!-- Sample Row - Replace with your data -->
                                    <tr class="table-row">
                                        <td class="py-4 px-4">
                                            <span class="bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-lg text-sm">1</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold">S</span>
                                                </div>
                                                <span class="font-semibold text-gray-800">Sample Entry</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-600">
                                            <i class="fas fa-clock text-gray-400 mr-2"></i>
                                            {{ date('Y-m-d H:i') }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition-all shadow-md hover:shadow-lg" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-all shadow-md hover:shadow-lg" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Empty State -->
                                    <tr>
                                        <td colspan="4" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-inbox text-6xl mb-4"></i>
                                                <p class="text-xl font-semibold mb-2">No entries yet</p>
                                                <p class="text-sm">Create your first entry to get started!</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                Showing <span class="font-bold">0</span> to <span class="font-bold">0</span> of <span class="font-bold">0</span> entries
                            </p>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-500 transition-all disabled:opacity-50" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="px-4 py-2 bg-indigo-500 text-white rounded-lg font-bold">1</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-500 transition-all disabled:opacity-50" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-12 py-6 border-t border-gray-200">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <p class="flex items-center justify-center gap-2">
                <i class="fas fa-code text-indigo-500"></i>
                Made with <i class="fas fa-heart text-red-500"></i> for CRUD Operations
            </p>
        </div>
    </footer>

    <script>
        // Auto-hide success messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html> --}}
