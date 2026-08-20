@extends('seller.layouts.index')

@section('title', 'Transfer Coins')

@section('content')
<div style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('seller.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Transfer Coins</span>
    </span>
</div>

<div class="profile-layout-container" style="display: flex; flex-direction: column; gap: 2rem;">
    <!-- Search User Box -->
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">🔍</span>
            <h2>Search Recipient User</h2>
        </div>

        <div style="padding: 1.5rem;">
            <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                <div class="form-group-custom" style="flex: 1; min-width: 250px;">
                    <label class="form-label" for="search_query">Enter User ID or Mobile Number<span class="req">*</span></label>
                    <input type="text" id="search_query" class="form-input" placeholder="e.g. QB10001 or 9876543210" required>
                </div>
                <button type="button" class="btn-profile-save" id="btn-search-user" style="height: 48px; min-width: 120px;">Search</button>
            </div>
            <div class="validation-error-message" id="search-error-msg" style="margin-top: 0.5rem; display: none;"></div>
        </div>
    </div>

    <!-- Recipient & Transfer Form (Hidden until searched) -->
    <div class="profile-content-card" id="transfer-card" style="width: 100%; display: none;">
        <div class="profile-card-header">
            <span class="header-icon">🪙</span>
            <h2>Coin Transfer Details</h2>
        </div>

        <div style="padding: 1.5rem;">
            <div style="display: flex; gap: 2rem; align-items: center; border-bottom: 1px solid #2e2a47; padding-bottom: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <!-- Recipient Preview -->
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img id="recipient-image" src="" alt="User image" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #3b82f6;">
                    <div>
                        <h3 id="recipient-name" style="color: #ffffff; margin: 0 0 0.25rem 0; font-size: 1.2rem; font-weight: 700;"></h3>
                        <span style="display: block; color: #8e89a5; font-size: 0.9rem; margin-bottom: 0.25rem;">User ID: <strong id="recipient-uid" style="color: #ffffff;"></strong></span>
                        <span style="display: block; color: #8e89a5; font-size: 0.9rem;">Mobile: <strong id="recipient-mobile" style="color: #ffffff;"></strong></span>
                    </div>
                </div>

                <!-- Recipient Wallet -->
                <div style="background-color: #1e1b2e; padding: 1rem 1.5rem; border-radius: 8px; border: 1px solid #2e2a47;">
                    <span style="color: #8e89a5; font-size: 0.8rem; display: block; margin-bottom: 0.25rem; font-weight: 600;">CURRENT BALANCE</span>
                    <strong id="recipient-coins" style="color: #38bdf8; font-size: 1.5rem; font-weight: 800;"></strong>
                </div>

                <!-- Recipient Status -->
                <div style="background-color: #1e1b2e; padding: 1rem 1.5rem; border-radius: 8px; border: 1px solid #2e2a47;">
                    <span style="color: #8e89a5; font-size: 0.8rem; display: block; margin-bottom: 0.25rem; font-weight: 600;">STATUS</span>
                    <span id="recipient-status" style="background-color: #22c55e; color: #ffffff; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; font-weight: 700; display: inline-block;">Active</span>
                </div>
            </div>

            <!-- Transfer Input Form -->
            <form id="transfer-form">
                @csrf
                <input type="hidden" id="recipient-id-input" name="user_id">

                <div class="form-group-custom" style="margin-bottom: 1.5rem; max-width: 400px;">
                    <label class="form-label" for="amount">Coins Amount to Transfer<span class="req">*</span></label>
                    <input type="number" id="amount" name="amount" class="form-input" min="1" step="1" placeholder="Enter coins to send" required>
                    <div class="validation-error-message" id="transfer-error-msg" style="margin-top: 0.5rem; display: none;"></div>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="button" class="btn-profile-save" id="btn-confirm-transfer" style="background-color: #a855f7;">Confirm & Transfer</button>
                    <button type="button" class="btn-profile-save" id="btn-cancel-transfer" style="background-color: #4b5563;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Dialog Modal -->
<div id="confirm-modal" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background-color: #161426; border: 1px solid #2e2a47; border-radius: 12px; max-width: 450px; width: 100%; padding: 2rem; position: relative;">
        <h3 style="color: #ffffff; margin-top: 0; font-size: 1.3rem; margin-bottom: 1rem; border-bottom: 1px solid #2e2a47; padding-bottom: 0.5rem;">Confirm Transaction</h3>
        <p style="color: #e2e8f0; font-size: 0.95rem; line-height: 1.5;">
            Are you sure you want to transfer <strong id="modal-amount" style="color: #ff9800; font-size: 1.1rem;"></strong> coins to <strong id="modal-username" style="color: #ffffff;"></strong> (ID: <span id="modal-uid"></span>)?
        </p>
        <div style="background-color: #1e1b2e; border-radius: 6px; padding: 0.75rem; font-size: 0.85rem; color: #a855f7; margin-bottom: 1.5rem; border: 1px solid #2e2a47;">
            ⚠️ This operation is final and cannot be undone.
        </div>
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="button" id="btn-modal-cancel" style="background-color: #4b5563; border: none; color: #ffffff; padding: 0.5rem 1.2rem; border-radius: 6px; cursor: pointer; font-weight: 600;">No, Go Back</button>
            <button type="button" id="btn-modal-confirm" style="background-color: #22c55e; border: none; color: #ffffff; padding: 0.5rem 1.2rem; border-radius: 6px; cursor: pointer; font-weight: 600;">Yes, Transfer Now</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search_query');
        const btnSearch = document.getElementById('btn-search-user');
        const searchError = document.getElementById('search-error-msg');
        
        const transferCard = document.getElementById('transfer-card');
        const rImage = document.getElementById('recipient-image');
        const rName = document.getElementById('recipient-name');
        const rUid = document.getElementById('recipient-uid');
        const rMobile = document.getElementById('recipient-mobile');
        const rCoins = document.getElementById('recipient-coins');
        const rStatus = document.getElementById('recipient-status');
        const rIdInput = document.getElementById('recipient-id-input');

        const amountInput = document.getElementById('amount');
        const transferError = document.getElementById('transfer-error-msg');
        const btnConfirmTransfer = document.getElementById('btn-confirm-transfer');
        const btnCancelTransfer = document.getElementById('btn-cancel-transfer');

        const confirmModal = document.getElementById('confirm-modal');
        const modalAmount = document.getElementById('modal-amount');
        const modalUsername = document.getElementById('modal-username');
        const modalUid = document.getElementById('modal-uid');
        const btnModalCancel = document.getElementById('btn-modal-cancel');
        const btnModalConfirm = document.getElementById('btn-modal-confirm');

        // Search user
        btnSearch.addEventListener('click', function () {
            const query = searchInput.value.trim();
            searchError.style.display = 'none';
            searchError.textContent = '';
            transferCard.style.display = 'none';

            if (!query) {
                searchError.textContent = 'Please enter a valid User ID or Mobile Number.';
                searchError.style.display = 'block';
                return;
            }

            btnSearch.disabled = true;
            btnSearch.textContent = 'Searching...';

            fetch(`{{ route('seller.users.search') }}?search_query=${encodeURIComponent(query)}`)
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    btnSearch.disabled = false;
                    btnSearch.textContent = 'Search';

                    if (res.status === 200) {
                        const user = res.body.user;
                        
                        rImage.src = user.image_url;
                        rName.textContent = user.name;
                        rUid.textContent = user.u_id;
                        rMobile.textContent = user.mobile;
                        rCoins.textContent = user.coins.toLocaleString() + ' Coins';
                        rIdInput.value = user.id;

                        transferCard.style.display = 'block';
                        amountInput.value = '';
                        amountInput.focus();
                    } else {
                        searchError.textContent = res.body.message || 'User not found.';
                        searchError.style.display = 'block';
                    }
                })
                .catch(err => {
                    btnSearch.disabled = false;
                    btnSearch.textContent = 'Search';
                    searchError.textContent = 'An error occurred. Please try again.';
                    searchError.style.display = 'block';
                });
        });

        // Trigger confirmation modal
        btnConfirmTransfer.addEventListener('click', function () {
            transferError.style.display = 'none';
            transferError.textContent = '';

            const amount = parseInt(amountInput.value.trim());
            if (isNaN(amount) || amount <= 0) {
                transferError.textContent = 'Please enter a valid number of coins greater than 0.';
                transferError.style.display = 'block';
                return;
            }

            modalAmount.textContent = amount.toLocaleString();
            modalUsername.textContent = rName.textContent;
            modalUid.textContent = rUid.textContent;

            confirmModal.style.display = 'flex';
        });

        // Cancel modal
        btnModalCancel.addEventListener('click', function () {
            confirmModal.style.display = 'none';
        });

        // Confirm inside modal -> post API
        btnModalConfirm.addEventListener('click', function () {
            confirmModal.style.display = 'none';
            btnConfirmTransfer.disabled = true;
            btnConfirmTransfer.textContent = 'Processing Transfer...';

            const payload = {
                user_id: rIdInput.value,
                amount: amountInput.value
            };

            fetch('{{ route('seller.transfer.submit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btnConfirmTransfer.disabled = false;
                btnConfirmTransfer.textContent = 'Confirm & Transfer';

                if (res.status === 200) {
                    alert('Success! Coins transferred successfully. Transaction ID: ' + res.body.reference_id);
                    window.location.href = '{{ route('seller.dashboard') }}';
                } else {
                    transferError.textContent = res.body.message || 'Transfer failed.';
                    transferError.style.display = 'block';
                }
            })
            .catch(err => {
                btnConfirmTransfer.disabled = false;
                btnConfirmTransfer.textContent = 'Confirm & Transfer';
                transferError.textContent = 'An error occurred. Please try again.';
                transferError.style.display = 'block';
            });
        });

        // Cancel transfer
        btnCancelTransfer.addEventListener('click', function () {
            transferCard.style.display = 'none';
            searchInput.value = '';
            searchInput.focus();
        });
    });
</script>
@endsection
