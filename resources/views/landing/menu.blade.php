<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu | Caffeshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo seanspace.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

    {{-- Fonts/Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .cart-icon-btn { background: none; border: none; position: relative; cursor: pointer; }
        .cart-count { position: absolute; top: -6px; right: -8px; background:#0d6efd; color:white; font-size:11px; padding:2px 6px; border-radius:12px;}
        .cart-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:2000; display:none; opacity:0; transition:opacity .2s; }
        .cart-backdrop.open { display:block; opacity:1; }
        .cart-panel { position:fixed; top:0; right:0; width:380px; max-width:96%; height:100%; background:white; z-index:2001; transform:translateX(110%); transition:transform .25s; box-shadow: -3px 0 20px rgba(0,0,0,0.15); overflow:auto; }
        .cart-panel.open { transform:translateX(0); }
        .cart-panel-header { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid #eee;}
        .cart-panel-body { padding:16px; }
        .cart-panel-footer { padding:12px 16px; border-top:1px solid #eee; position:sticky; bottom:0; background:white; }
        .cart-item { display:flex; gap:10px; padding:8px 0; border-bottom:1px solid #f2f2f2;}
        .cart-item-thumb img { width:62px; height:62px; object-fit:cover; border-radius:8px;}
        .cart-item-info { flex:1; }
        .cart-item-actions { margin-top:6px; }
        .btn-cart-checkout { background:#0d6efd; border:none; color:white; padding:10px 14px; border-radius:6px; }
        /* small helper for injected button */
        #snapReturnBtn { box-shadow: none; }

        /* ===== MODAL HIGH Z-INDEX STYLES (buat modal muncul di atas cart) ===== */
        .modal-backdrop.custom-high {
          z-index: 2500 !important;
        }
        .modal.custom-high {
          z-index: 2501 !important;
        }
        body.modal-open {
          overflow: hidden;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom py-3 sticky-top">
    <div class="container d-flex align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand mb-0" href="{{ url('/') }}">Caffeshop</a>
            <button type="button" class="cart-icon-btn nav-cart" aria-label="Keranjang">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count">0</span>
            </button>
        </div>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#gallery">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#contact">Kontak</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Menu</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="menu-section py-5">
    <div class="container">
        <div class="menu-header-row d-flex flex-wrap align-items-center gap-3 mb-4">
            <div class="section-tabs flex-grow-1">
                <button class="menu-tab active" data-filter="all">Semua</button>
                <button class="menu-tab" data-filter="kopi">Kopi</button>
                <button class="menu-tab" data-filter="non kopi">Non Coffee</button>
                <button class="menu-tab" data-filter="cemilan">Cemilan</button>
                <button class="menu-tab" data-filter="makanan">Makanan</button>
            </div>

            <div class="search-cart-row d-flex align-items-center gap-2 ms-md-auto w-100 w-md-auto">
                <form id="searchForm" class="product-search d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari menu...">
                    <button type="submit" class="btn btn-dark ms-2">Cari</button>
                </form>
            </div>
        </div>

        <div class="row g-4 menu-products">
            @foreach ($products as $product)
                @php $priceFormatted = 'Rp ' . number_format($product->price, 0, ',', '.'); @endphp
                <div class="col-12 menu-col">
                    <article class="product-card" data-id="{{ $product->id }}" data-category="{{ strtolower($product->category) }}">
                        <div class="product-media">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                            @if ($product->stock > 0)
                                <span class="stock-badge available">Tersedia</span>
                            @else
                                <span class="stock-badge out">Habis</span>
                            @endif
                        </div>

                        <div class="product-body">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-price">{{ $priceFormatted }}</p>
                        </div>

                        <div class="product-footer">
                            @if ($product->stock > 0)
                                <button type="button" class="product-btn product-btn-primary">Add to cart</button>
                            @else
                                <button type="button" class="product-btn product-btn-primary product-btn-disabled" disabled>Stok habis</button>
                            @endif

                            <button type="button" class="product-btn product-btn-outline" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
                                Details
                            </button>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

@foreach ($products as $product)
    <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel-{{ $product->id }}">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex gap-3">
                <div class="flex-shrink-0 modal-image-wrapper">
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:140px;border-radius:8px;">
                </div>
                <div>
                    <p><strong>Kategori:</strong> {{ $product->category }}</p>
                    <p><strong>Harga:</strong> {{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                    <p>{{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}</p>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
        </div></div>
    </div>
@endforeach

<div class="cart-backdrop" id="cartBackdrop"></div>

<aside class="cart-panel" id="cartPanel">
    <div class="cart-panel-header">
        <div class="cart-panel-title"><i class="fa-solid fa-bag-shopping"></i> <span>Keranjang Belanja</span></div>
        <button type="button" class="cart-close-btn" id="cartCloseBtn"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="cart-panel-body">
        <div class="cart-items" id="cartItemsContainer">
            <p class="cart-empty">Keranjang masih kosong.</p>
        </div>

        <div id="cartOrderForm" class="mt-4">
            <h6>Data Pemesan</h6>

            <div id="cartItemsSummary" class="mb-2 small text-muted"></div>

            <div class="mb-2">
                <input type="text" id="customerName" class="form-control" placeholder="Nama lengkap">
            </div>
            <div class="mb-2">
                <input type="text" id="customerPhone" class="form-control" placeholder="No. HP / WhatsApp">
            </div>

            <div class="mb-2">
                <textarea id="note" class="form-control" placeholder="Tambahan / catatan (opsional)"></textarea>
            </div>

            <div class="text-center small text-muted mb-2">Atau kembali ke menu untuk menambah item</div>
        </div>

        <div id="cartOrderArea" class="mt-4" style="display:none;"></div>

        @if(session('last_order'))
            <script>
                try {
                    const s = {!! json_encode(session('last_order')) !!};
                    const stored = {
                        id: s.id ?? s.order_id ?? null,
                        payment_url: s.payment_url ?? null,
                        status: s.status ?? 'pending',
                    };
                    sessionStorage.setItem('last_order', JSON.stringify(stored));
                } catch(e) { console.error(e); }
            </script>
        @endif
    </div>

    <div class="cart-panel-footer">
        <div class="cart-total-row d-flex justify-content-between mb-2"><div>Total:</div><div id="cartTotal">Rp 0</div></div>
        <button id="openOrderFormBtn" class="btn btn-cart-checkout w-100" disabled>Buat Pesanan & Bayar</button>
    </div>
</aside>

<footer class="footer">
    <div class="container d-flex justify-content-between flex-wrap gap-2"><span>© {{ date('Y') }} Caffeshop. All rights reserved.</span></div>
</footer>

{{-- Note: Midtrans JS removed (we no longer use it) --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const CHECKOUT_URL = "{{ route('checkout.process') }}";
  const cartButton = document.querySelector('.nav-cart');
  const cartCountEl = document.querySelector('.cart-count');
  const cartBackdrop = document.querySelector('.cart-backdrop');
  const cartPanel = document.querySelector('.cart-panel');
  const cartItemsContainer = document.getElementById('cartItemsContainer');
  const cartTotalEl = document.getElementById('cartTotal');
  const cartCloseBtn = document.getElementById('cartCloseBtn');
  const openOrderFormBtn = document.getElementById('openOrderFormBtn');
  const cartItemsSummary = document.getElementById('cartItemsSummary');

  const inputName = document.getElementById('customerName');
  const inputPhone = document.getElementById('customerPhone');
  const inputNote = document.getElementById('note');

  const addToCartButtons = document.querySelectorAll('.product-btn-primary:not(.product-btn-disabled)');
  const productCards = document.querySelectorAll('.product-card');
  const tabs = document.querySelectorAll('.menu-tab');
  const searchForm = document.getElementById('searchForm');
  const searchInput = document.getElementById('searchInput');

  const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

  let cartItems = [];
  try { cartItems = JSON.parse(localStorage.getItem('cartItems')) || []; } catch(e){ cartItems = []; }

  try { sessionStorage.removeItem('last_order'); } catch(e){}

  function formatRupiah(num){ return 'Rp ' + (num || 0).toLocaleString('id-ID'); }

  function openCart(){
    if(!cartPanel || !cartBackdrop) return;
    cartBackdrop.style.display = 'block';
    requestAnimationFrame(()=>{ cartBackdrop.classList.add('open'); cartPanel.classList.add('open'); document.body.style.overflow = 'hidden'; });
  }

  function closeCart(){
    if(!cartPanel || !cartBackdrop) return;
    cartBackdrop.classList.remove('open');
    cartPanel.classList.remove('open');
    document.body.style.overflow = '';
    const handler = function(ev){ if(ev && ev.propertyName && ev.propertyName !== 'opacity') return; cartBackdrop.style.display = 'none'; cartBackdrop.removeEventListener('transitionend', handler); };
    cartBackdrop.addEventListener('transitionend', handler);
    setTimeout(()=>{ if(!cartBackdrop.classList.contains('open')) cartBackdrop.style.display = 'none'; }, 350);
  }

  if(cartButton) cartButton.addEventListener('click', ()=> cartPanel.classList.contains('open') ? closeCart() : openCart());
  if(cartBackdrop) cartBackdrop.addEventListener('click', closeCart);
  if(cartCloseBtn) cartCloseBtn.addEventListener('click', closeCart);

  function renderCart(){
    if(!cartItemsContainer) return;
    cartItemsContainer.innerHTML = '';
    if(!cartItems || cartItems.length === 0){
      cartItemsContainer.innerHTML = '<p class="cart-empty">Keranjang masih kosong.</p>';
    } else {
      cartItems.forEach(item=>{
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.dataset.productId = item.id;
        div.innerHTML = `
          <div class="cart-item-thumb"><img src="${item.image || 'https://via.placeholder.com/80'}" alt="${item.name}"></div>
          <div class="cart-item-info">
            <div class="cart-item-name">${item.name}</div>
            <div class="cart-item-price small text-muted">${formatRupiah(item.price)} × ${item.qty}</div>
            <div class="cart-item-actions mt-1">
              <button class="cart-qty-btn btn btn-sm btn-light me-1" data-cart-action="minus" data-product-id="${item.id}">-</button>
              <span class="cart-qty px-2">${item.qty}</span>
              <button class="cart-qty-btn btn btn-sm btn-light ms-1" data-cart-action="plus" data-product-id="${item.id}">+</button>
              <button class="cart-remove-btn btn btn-sm btn-link text-danger" data-cart-action="remove" data-product-id="${item.id}">Hapus</button>
            </div>
          </div>
        `;
        cartItemsContainer.appendChild(div);
      });
    }

    const total = cartItems.reduce((s,p)=> s + (p.price * p.qty), 0);
    if(cartTotalEl) cartTotalEl.textContent = formatRupiah(total);
    const count = cartItems.reduce((s,p)=> s + p.qty, 0);
    if(cartCountEl) cartCountEl.textContent = count;

    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    renderCartSummaryForForm();
    if(openOrderFormBtn) openOrderFormBtn.disabled = cartItems.length === 0;
  }

  function renderCartSummaryForForm(){
    if(!cartItemsSummary) return;
    if(!cartItems || cartItems.length === 0){
      cartItemsSummary.innerHTML = '<div class="small text-muted">Keranjang masih kosong.</div>';
      return;
    }
    cartItemsSummary.innerHTML = cartItems.map(i=> `<div class="d-flex justify-content-between"><div>${i.name} x ${i.qty}</div><div>${formatRupiah(i.price * i.qty)}</div></div>`).join('');
  }

  if(cartItemsContainer){
    cartItemsContainer.addEventListener('click', function(e){
      const btn = e.target.closest('[data-cart-action]');
      if(!btn) return;
      const action = btn.dataset.cartAction;
      const id = parseInt(btn.dataset.productId,10);
      const item = cartItems.find(p=> p.id === id);
      if(!item) return;
      if(action === 'plus'){ item.qty++; }
      else if(action === 'minus'){ item.qty--; if(item.qty <= 0) cartItems = cartItems.filter(p=> p.id !== id); }
      else if(action === 'remove'){ cartItems = cartItems.filter(p=> p.id !== id); }
      renderCart();
    });
  }

  function animateToCart(imgEl){
    if(!imgEl || !cartButton) return;
    const imgRect = imgEl.getBoundingClientRect();
    const cartRect = cartButton.getBoundingClientRect();
    const flying = imgEl.cloneNode(true);
    flying.style.position='fixed'; flying.style.left = imgRect.left+'px'; flying.style.top = imgRect.top+'px';
    flying.style.width = imgRect.width+'px'; flying.style.height = imgRect.height+'px';
    flying.style.transition = 'all .7s ease-in-out'; flying.style.zIndex = 9999; document.body.appendChild(flying);
    requestAnimationFrame(()=> {
      flying.style.left = (cartRect.left + cartRect.width/2 - imgRect.width*0.3) + 'px';
      flying.style.top = (cartRect.top + cartRect.height/2 - imgRect.height*0.3) + 'px';
      flying.style.transform = 'scale(.3)'; flying.style.opacity = '0.2';
    });
    setTimeout(()=> flying.remove(), 750);
  }

  addToCartButtons.forEach(btn=>{
    btn.addEventListener('click', function(){
      const card = this.closest('.product-card'); if(!card) return;
      const imgEl = card.querySelector('.product-media img');
      let id = parseInt(card.dataset.id,10); if(isNaN(id)) id = Date.now();
      const name = card.querySelector('.product-title').textContent.trim();
      const priceText = card.querySelector('.product-price').textContent.replace(/[^\d]/g,'');
      const price = parseInt(priceText || '0',10);
      const image = imgEl ? imgEl.src : '';
      const exist = cartItems.find(p=> p.id === id);
      if(exist) exist.qty++;
      else cartItems.push({ id, name, price, image, qty: 1 });

      renderCart();
      animateToCart(imgEl);
    });
  });

  // ---------- Checkout: kirim data ke server lalu redirect ke halaman review ----------
  async function doCheckout(payload){
    try {
      if(openOrderFormBtn) { openOrderFormBtn.disabled = true; openOrderFormBtn.textContent = 'Memproses...'; }

      const res = await fetch(CHECKOUT_URL, {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept':'application/json' },
        body: JSON.stringify(payload)
      });

      const json = await res.json();
      if(!res.ok || !json.success) {
        throw new Error(json.message || 'Gagal membuat pesanan.');
      }

      // redirect ke halaman review (server akan mengisi session)
      if(json.redirect) {
        window.location.href = json.redirect;
      } else {
        Swal.fire({ icon:'success', title:'Berhasil', text:'Pesanan dibuat. Lanjut ke halaman berikutnya.' }).then(()=> {
          window.location.href = '/checkout/review';
        });
      }
    } catch(err){
      console.error('Checkout failed', err);
      Swal.fire({ icon:'error', title:'Gagal', text: err.message || 'Terjadi kesalahan jaringan' });
    } finally {
      if(openOrderFormBtn) { openOrderFormBtn.disabled = false; openOrderFormBtn.textContent = 'Buat Pesanan & Bayar'; }
    }
  }

  if (openOrderFormBtn){
    openOrderFormBtn.addEventListener('click', function(){
      if(!cartItems || cartItems.length === 0){
        Swal.fire({ icon:'warning', title:'Keranjang kosong', text:'Tambahkan produk terlebih dahulu.' });
        return;
      }
      const payload = {
        customer_name: (inputName && inputName.value.trim()) || 'Pelanggan',
        phone: (inputPhone && inputPhone.value.trim()) || '',
        note: (inputNote && inputNote.value.trim()) || '',
        cart: JSON.stringify(cartItems)
      };
      doCheckout(payload);
    });
  }

  // tabs/search behavior
  function updateDisplay(){
    const q = (searchInput && searchInput.value || '').trim().toLowerCase();
    productCards.forEach(card=>{
      const col = card.closest('.menu-col');
      const title = card.querySelector('.product-title').textContent.toLowerCase();
      const catTextEl = card.querySelector('.product-category');
      const catText = catTextEl ? catTextEl.textContent.toLowerCase() : '';
      const matchSearch = !q || title.includes(q) || catText.includes(q);
      col.style.display = matchSearch ? '' : 'none';
    });
  }

  tabs.forEach(tab => tab.addEventListener('click', function(){
    tabs.forEach(t=>t.classList.remove('active'));
    this.classList.add('active');
    const f = this.dataset.filter;
    productCards.forEach(card=>{
      const category = (card.dataset.category || '').toLowerCase();
      if(f === 'all' || category === f.toLowerCase()) card.closest('.menu-col').style.display = '';
      else card.closest('.menu-col').style.display = 'none';
    });
  }));
  if(searchForm) searchForm.addEventListener('submit', function(e){ e.preventDefault(); updateDisplay(); });

  renderCart();
});
</script>

</body>
</html>
