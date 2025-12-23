<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Entry - CRUD Management</title>
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

        .scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pulse-animation {
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

        .backdrop-blur {
            backdrop-filter: blur(10px);
        }
    </style>
</head>
@foreach ($info as $data)

@endforeach
<body class="bg-gray-50 min-h-screen">
    <!-- Header with Gradient -->
    <div class="gradient-bg text-white py-8 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2 flex items-center gap-3">
                        <i class="fas fa-edit"></i>
                        Edit Entry
                    </h1>
                    <p class="text-indigo-100 text-lg">Update your data with ease</p>
                </div>
                <div class="pulse-animation">
                    <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                        <span class="font-semibold">ID: {{ $data->id ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('crud.index') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-gray-400"></i></li>
                <li class="text-indigo-600 font-medium">Edit Entry</li>
            </ol>
        </nav>

        <div class="max-w-2xl mx-auto">
            <!-- Success/Error Messages -->
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

            <!-- Edit Form Card -->
            <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                    <div class="flex items-center text-white">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-edit text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Update Entry</h2>
                            <p class="text-indigo-100 text-sm">Make changes to your data below</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Current Data Display -->
                    @if(isset($data))
                    <div class="mb-8 p-6 bg-gray-50 rounded-xl border-l-4 border-indigo-500">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                            Current Entry Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Entry ID</label>
                                <p class="text-lg font-bold text-indigo-600">#{{ $data->id }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Created</label>
                                <p class="text-gray-800">{{ $data->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Edit Form -->
                    @if(isset($data))
                    <form action="{{ route('crud.edit', $data->id) }}" method="POST" class="space-y-6 scale-in">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-indigo-500"></i>Entry Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $data->name) }}"
                                placeholder="Enter a new name..."
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none input-focus text-gray-800 font-medium"
                            >
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Choose a descriptive name for your entry
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button
                                type="submit"
                                class="btn-gradient text-white font-bold py-3 px-8 rounded-xl flex items-center justify-center gap-2 shadow-lg flex-1"
                            >
                                <i class="fas fa-save"></i>
                                Update Entry
                            </button>

                            <a
                                href="{{ route('crud.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg"
                            >
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                    @else
                    <!-- No Data State -->
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-triangle text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Entry Found</h3>
                        <p class="text-gray-500 mb-6">The entry you're trying to edit doesn't exist.</p>
                        <a
                            href="{{ route('crud.index') }}"
                            class="btn-gradient text-white font-bold py-3 px-8 rounded-xl inline-flex items-center gap-2 shadow-lg"
                        >
                            <i class="fas fa-arrow-left"></i>
                            Back to Dashboard
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats Card -->
            @if(isset($data))
            <div class="mt-6 bg-white rounded-xl card-shadow p-6 fade-in">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-indigo-500 mr-2"></i>
                    Entry Statistics
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <i class="fas fa-hashtag text-indigo-600 text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-indigo-600">#{{ $data->id }}</p>
                        <p class="text-sm text-gray-600 font-medium">Entry ID</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <i class="fas fa-calendar text-green-600 text-2xl mb-2"></i>
                        <p class="text-sm font-bold text-green-600">{{ $data->created_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-600 font-medium">Created</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <i class="fas fa-clock text-purple-600 text-2xl mb-2"></i>
                        <p class="text-sm font-bold text-purple-600">{{ $data->updated_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-600 font-medium">Last Updated</p>
                    </div>
                </div>
            endif
        </div>
            </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-12 py-6 border-t border-gray-200">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <p class="flex items-center justify-center gap-2">
                <i class="fas fa-code text-indigo-500"></i>
                Made with <i class="fas fa-heart text-red-500"></i> for Better Data Management
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

        // Form validation enhancement
        const form = document.querySelector('form');
        const nameInput = document.getElementById('name');

        if (nameInput && form) {
            form.addEventListener('submit', function(e) {
                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    nameInput.focus();
                    nameInput.style.borderColor = '#ef4444';
                    setTimeout(() => {
                        nameInput.style.borderColor = '#d1d5db';
                    }, 2000);
                }
            });

            // Real-time character count
            const charCount = document.createElement('div');
            charCount.className = 'text-sm text-gray-500 mt-1';
            nameInput.parentNode.appendChild(charCount);

            function updateCharCount() {
                const length = nameInput.value.length;
                charCount.textContent = `${length} characters`;

                if (length > 50) {
                    charCount.className = 'text-sm text-yellow-600 mt-1';
                } else if (length > 100) {
                    charCount.className = 'text-sm text-red-600 mt-1';
                } else {
                    charCount.className = 'text-sm text-gray-500 mt-1';
                }
            }

            nameInput.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
            @endif
        }
    </script>
</body>
</html>
