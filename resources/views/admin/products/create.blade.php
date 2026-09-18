@extends('admin.layout')

@section('title', 'নতুন প্রোডাক্ট যোগ করুন - এডমিন প্যানেল')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">নতুন প্রোডাক্ট যোগ করুন</h1>
            <p class="text-xs text-slate-500 mt-1">প্রোডাক্টের বিবরণ, মূল্য ও মিডিয়া ফাইল আপলোড করুন</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
            ← তালিকায় ফিরে যান
        </a>
    </div>

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">প্রোডাক্টের নাম <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদাঃ সুন্দরবনের খাঁটি চাকের মধু" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ক্যাটাগরি <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">SKU কোড</label>
                <input type="text" name="sku" value="{{ old('sku') }}" placeholder="উদাঃ ORG-HNY-01" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">রেগুলার প্রাইজ (৳) <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price') }}" required placeholder="১২৫০" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিক্রয় মূল্য / অফার প্রাইজ (৳) <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" required placeholder="৮৯০" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">স্টক পরিমাণ <span class="text-rose-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 50) }}" required 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <!-- ========================================================= -->
            <!-- PRODUCT MEDIA UPLOAD SECTION (MATCHING DEMANDHAT UI)      -->
            <!-- ========================================================= -->
            <div class="md:col-span-2 border-t border-slate-100 pt-6">
                <h3 class="text-base font-bold text-slate-900 mb-4">Product Media</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Main Thumbnail Column -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-slate-700">
                            Main Thumbnail <span class="text-rose-500">*</span>
                        </label>
                        
                        <div id="thumbnailDropzone" 
                             onclick="document.getElementById('thumbnailInput').click()"
                             class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl h-52 flex flex-col items-center justify-center p-4 cursor-pointer transition-all bg-slate-50/50 hover:bg-emerald-50/20 group select-none">
                            
                            <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" class="hidden" required onchange="handleThumbnailSelect(event)">
                            
                            <!-- Cloud Upload Placeholder -->
                            <div id="thumbnailPlaceholder" class="flex flex-col items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors pointer-events-none">
                                <svg class="w-12 h-12 stroke-current mb-2 stroke-[1.5]" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                                <span class="text-xs font-semibold text-slate-600 group-hover:text-emerald-700">ছবি আপলোড করতে ক্লিক করুন বা ড্র্যাগ করুন</span>
                                <span class="text-[10px] text-slate-400 mt-1">PNG, JPG, WEBP (Max 5MB)</span>
                            </div>

                            <!-- Image Preview Card -->
                            <div id="thumbnailPreviewContainer" class="hidden absolute inset-0 rounded-2xl overflow-hidden p-2 bg-white flex items-center justify-center group/preview">
                                <img id="thumbnailPreviewImg" src="" alt="Thumbnail preview" class="w-full h-full object-contain rounded-xl">
                                <div class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover/preview:opacity-100 transition-opacity rounded-2xl flex items-center justify-center gap-2">
                                    <button type="button" onclick="event.stopPropagation(); document.getElementById('thumbnailInput').click();" class="px-3 py-1.5 bg-white text-slate-800 rounded-lg text-xs font-bold shadow hover:bg-slate-100 cursor-pointer">
                                        পরিবর্তন করুন
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); removeThumbnail();" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-bold shadow hover:bg-rose-700 cursor-pointer">
                                        মুছে ফেলুন
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Images Column -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-slate-700">
                            Gallery Images
                        </label>

                        <div id="galleryDropzone"
                             onclick="document.getElementById('galleryInput').click()"
                             class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl min-h-[13rem] flex flex-col items-center justify-center p-4 cursor-pointer transition-all bg-slate-50/50 hover:bg-emerald-50/20 group select-none">
                            
                            <input type="file" name="gallery[]" id="galleryInput" multiple accept="image/*" class="hidden" onchange="handleGallerySelect(event)">

                            <!-- Plus Sign Placeholder -->
                            <div id="galleryPlaceholder" class="flex flex-col items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors pointer-events-none">
                                <svg class="w-12 h-12 stroke-current mb-2 stroke-[1.5]" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="text-xs font-semibold text-slate-600 group-hover:text-emerald-700">গ্যালারির জন্য একাধিক ছবি যুক্ত করুন</span>
                                <span class="text-[10px] text-slate-400 mt-1">ক্লিক বা ড্র্যাগ করে সিলেক্ট করুন</span>
                            </div>

                            <!-- Gallery Images Grid -->
                            <div id="galleryGrid" class="hidden w-full grid grid-cols-3 gap-2.5 p-1" onclick="event.stopPropagation()">
                                <!-- Dynamically filled with previews and add button -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ (Short Description)</label>
                <textarea name="short_description" rows="2" placeholder="১-২ লাইনে পণ্যের আকর্ষনীয় বিবরণ" 
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('short_description') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">বিস্তারিত বিবরণ (Full Description)</label>
                <textarea name="description" rows="4" placeholder="পণ্যের সম্পূর্ণ গুণাগুণ ও ব্যবহারের নিয়ম" 
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">মূল বৈশিষ্ট্য ও বুলেটের তালিকা (প্রতি লাইনে ১টি)</label>
                <textarea name="features_input" rows="3" placeholder="১০০% খাঁটি ও ভেজালমুক্ত&#10;ল্যাব টেস্টে পরীক্ষিত&#10;ক্যাশ অন ডেলিভারি" 
                          class="w-full px-4 py-2 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('features_input') }}</textarea>
            </div>

            <div class="md:col-span-2 flex flex-wrap items-center gap-6 pt-2 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>সক্রিয় প্রোডাক্ট (Active)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>ফিচার্ড প্রোডাক্ট (Featured)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_flash_deal" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>ফ্ল্যাশ সেল ডিসকাউন্টে যোগ করুন</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition-colors cursor-pointer">
                প্রোডাক্ট সংরক্ষণ করুন
            </button>
        </div>
    </form>

</div>

<script>
    // -------------------------------------------------------------
    // 1. Thumbnail Upload & Preview
    // -------------------------------------------------------------
    const thumbInput = document.getElementById('thumbnailInput');
    const thumbPlaceholder = document.getElementById('thumbnailPlaceholder');
    const thumbPreviewContainer = document.getElementById('thumbnailPreviewContainer');
    const thumbPreviewImg = document.getElementById('thumbnailPreviewImg');
    const thumbDropzone = document.getElementById('thumbnailDropzone');

    function handleThumbnailSelect(event) {
        const file = event.target.files[0];
        if (file) {
            displayThumbnailFile(file);
        }
    }

    function displayThumbnailFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            thumbPreviewImg.src = e.target.result;
            thumbPlaceholder.classList.add('hidden');
            thumbPreviewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeThumbnail() {
        thumbInput.value = '';
        thumbPreviewImg.src = '';
        thumbPreviewContainer.classList.add('hidden');
        thumbPlaceholder.classList.remove('hidden');
    }

    // Drag and Drop for Thumbnail
    ['dragenter', 'dragover'].forEach(eventName => {
        thumbDropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            thumbDropzone.classList.add('border-emerald-500', 'bg-emerald-50/40');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        thumbDropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            thumbDropzone.classList.remove('border-emerald-500', 'bg-emerald-50/40');
        }, false);
    });

    thumbDropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        if (file && file.type.startsWith('image/')) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            thumbInput.files = dataTransfer.files;
            displayThumbnailFile(file);
        }
    });

    // -------------------------------------------------------------
    // 2. Gallery Upload & Multi-Preview with DataTransfer
    // -------------------------------------------------------------
    const galleryInput = document.getElementById('galleryInput');
    const galleryPlaceholder = document.getElementById('galleryPlaceholder');
    const galleryGrid = document.getElementById('galleryGrid');
    const galleryDropzone = document.getElementById('galleryDropzone');

    let galleryFiles = new DataTransfer();

    function handleGallerySelect(event) {
        const files = Array.from(event.target.files);
        addFilesToGallery(files);
    }

    function addFilesToGallery(newFiles) {
        newFiles.forEach(file => {
            if (file.type.startsWith('image/')) {
                galleryFiles.items.add(file);
            }
        });
        galleryInput.files = galleryFiles.files;
        renderGalleryPreviews();
    }

    function removeGalleryItem(index) {
        const dt = new DataTransfer();
        const currentFiles = galleryFiles.files;
        for (let i = 0; i < currentFiles.length; i++) {
            if (i !== index) {
                dt.items.add(currentFiles[i]);
            }
        }
        galleryFiles = dt;
        galleryInput.files = galleryFiles.files;
        renderGalleryPreviews();
    }

    function renderGalleryPreviews() {
        const count = galleryFiles.files.length;
        if (count === 0) {
            galleryGrid.innerHTML = '';
            galleryGrid.classList.add('hidden');
            galleryPlaceholder.classList.remove('hidden');
            return;
        }

        galleryPlaceholder.classList.add('hidden');
        galleryGrid.classList.remove('hidden');
        galleryGrid.innerHTML = '';

        Array.from(galleryFiles.files).forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'relative group/card aspect-square rounded-xl overflow-hidden border border-slate-200 bg-white shadow-xs flex items-center justify-center';

            const img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            const reader = new FileReader();
            reader.onload = (e) => img.src = e.target.result;
            reader.readAsDataURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.title = 'Remove Image';
            removeBtn.className = 'absolute top-1 right-1 w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs font-bold shadow-md hover:bg-rose-700 transition-colors opacity-90 hover:opacity-100 cursor-pointer';
            removeBtn.innerHTML = '×';
            removeBtn.onclick = (e) => {
                e.stopPropagation();
                removeGalleryItem(index);
            };

            card.appendChild(img);
            card.appendChild(removeBtn);
            galleryGrid.appendChild(card);
        });

        // Append "+" Add More card to the grid
        const addMoreCard = document.createElement('div');
        addMoreCard.className = 'aspect-square rounded-xl border-2 border-dashed border-slate-300 hover:border-emerald-500 flex flex-col items-center justify-center text-slate-400 hover:text-emerald-600 cursor-pointer transition-colors bg-white hover:bg-emerald-50/20';
        addMoreCard.innerHTML = `
            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="text-[10px] font-bold mt-0.5">Add</span>
        `;
        addMoreCard.onclick = (e) => {
            e.stopPropagation();
            galleryInput.click();
        };
        galleryGrid.appendChild(addMoreCard);
    }

    // Drag and Drop for Gallery
    ['dragenter', 'dragover'].forEach(eventName => {
        galleryDropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            galleryDropzone.classList.add('border-emerald-500', 'bg-emerald-50/40');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        galleryDropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            galleryDropzone.classList.remove('border-emerald-500', 'bg-emerald-50/40');
        }, false);
    });

    galleryDropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = Array.from(dt.files);
        addFilesToGallery(files);
    });
</script>
@endsection
