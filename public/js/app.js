
(function () {
    const peso = (n) => Number(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    document.querySelectorAll('[data-filter-scope]').forEach((scope) => {
        const tabs = scope.querySelector('[data-tabs]');
        const search = scope.querySelector('[data-search]');
        let cat = 'all';

        const apply = () => {
            const q = search ? search.value.trim().toLowerCase() : '';

            scope.querySelectorAll('[data-cat]:not(.tab)').forEach((el) => {
                if (el.classList.contains('cat-section')) return;
                const okCat = cat === 'all' || el.dataset.cat === cat;
                const text = (el.dataset.text || el.textContent).toLowerCase();
                el.hidden = !(okCat && text.includes(q));
            });

            scope.querySelectorAll('.cat-section').forEach((sec) => {
                const okCat = cat === 'all' || sec.dataset.cat === cat;
                const anyTile = [...sec.querySelectorAll('.tile')].some((t) => t.textContent.toLowerCase().includes(q));
                sec.hidden = !(okCat && anyTile);
            });

            const empty = scope.querySelector('[data-empty]');
            if (empty) empty.hidden = [...scope.querySelectorAll('.cat-section')].some((s) => !s.hidden);
        };

        if (tabs) {
            tabs.addEventListener('click', (e) => {
                const tab = e.target.closest('.tab');
                if (!tab) return;
                tabs.querySelectorAll('.tab').forEach((t) => t.classList.toggle('active', t === tab));
                cat = tab.dataset.cat || 'all';
                apply();
            });
        }
        if (search) search.addEventListener('input', apply);
    });

    document.querySelectorAll('.tabs:not([data-tabs])').forEach((group) => {
        group.addEventListener('click', (e) => {
            const tab = e.target.closest('.tab');
            if (!tab) return;
            group.querySelectorAll('.tab').forEach((t) => t.classList.toggle('active', t === tab));
        });
    });

    const openModal = (id) => { const m = document.getElementById(id); if (m) m.hidden = false; };
    const closeModals = () => document.querySelectorAll('.modal-backdrop').forEach((m) => (m.hidden = true));

    document.addEventListener('click', (e) => {
        const opener = e.target.closest('[data-open-modal]');
        if (opener) return openModal(opener.dataset.openModal);
        if (e.target.closest('[data-close-modal]')) {
            const modal = e.target.closest('.modal-backdrop');
            if (modal) modal.hidden = true;
            return;
        }
        if (e.target.classList && e.target.classList.contains('modal-backdrop')) e.target.hidden = true;
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModals(); });

    document.querySelectorAll('[data-pick]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const [name, qty, kind] = btn.dataset.pick.split('|');
            const chip = document.getElementById('stock-chip');
            if (chip) chip.innerHTML = '<b></b><small></small>';
            if (chip) {
                chip.querySelector('b').textContent = name.toUpperCase();
                chip.querySelector('small').textContent = qty + ' · ' + kind;
            }
        });
    });

    const orders = window.DASH_ORDERS;
    if (orders) {
        let current = null;
        document.querySelectorAll('[data-order]').forEach((btn) => {
            btn.addEventListener('click', () => {
                current = btn.dataset.order;
                const o = orders[current];
                document.getElementById('order-title').textContent = 'Order #' + current;
                document.getElementById('order-sub').textContent = o.time + ', ' + o.method;

                const lines = document.getElementById('order-lines');
                lines.innerHTML = '';
                const addRow = (left, right) => {
                    const row = document.createElement('div');
                    row.innerHTML = '<span></span><span></span>';
                    row.children[0].textContent = left;
                    row.children[1].textContent = right;
                    lines.appendChild(row);
                };
                o.lines.forEach(([qty, name, price]) => addRow(qty + ' x ' + name, peso(qty * price)));
                if (o.method === 'Cash') {
                    addRow('Received/Change', peso(o.received) + '/' + peso(o.received - o.total));
                } else {
                    addRow('Reference no.', o.ref);
                }
                document.getElementById('order-total').textContent = peso(o.total);
                openModal('order-modal');
            });
        });

        const voidOpen = document.querySelector('[data-open-void]');
        if (voidOpen) {
            voidOpen.addEventListener('click', () => {
                const o = orders[current];
                document.getElementById('void-title').textContent = 'Order #' + current;
                document.getElementById('void-sub').textContent = o.time + ', ' + o.method + '. Are you sure you want to void order #' + current + '?';
                closeModals();
                openModal('void-modal');
            });
        }
    }

    const cartLines = document.getElementById('cart-lines');
    if (cartLines) {
        const products = {};
        document.querySelectorAll('[data-product]').forEach((p) => {
            products[p.dataset.id] = { id: p.dataset.id, name: p.dataset.name, price: parseFloat(p.dataset.price), img: p.dataset.img };
        });

        let cart = (window.DASH_SEED_CART || []).filter((l) => products[l.id]).map((l) => ({ ...products[l.id], qty: l.qty }));

        const method = document.getElementById('pay-method');
        const received = document.getElementById('received');
        const cashFields = document.getElementById('cash-fields');
        const refField = document.getElementById('ref-field');

        const render = () => {
            cartLines.innerHTML = '';
            if (!cart.length) {
                cartLines.innerHTML = '<p class="cart-empty">Tap a product to add it.</p>';
            }
            cart.forEach((line) => {
                const el = document.createElement('div');
                el.className = 'cart-line';
                el.innerHTML =
                    '<span class="thumb"><img alt=""></span>' +
                    '<span><b></b><small></small></span>' +
                    '<span class="stepper"><button type="button" data-act="dec" aria-label="Remove one">&minus;</button><span></span><button type="button" data-act="inc" aria-label="Add one">+</button></span>' +
                    '<button type="button" class="icon-btn" data-act="del" aria-label="Remove item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/></svg></button>';
                if (line.img) el.querySelector('img').src = line.img; else el.querySelector('img').remove();
                el.querySelector('b').textContent = line.name;
                el.querySelector('small').textContent = peso(line.price);
                el.querySelector('.stepper span').textContent = line.qty;
                el.dataset.id = line.id;
                cartLines.appendChild(el);
            });

            const total = cart.reduce((s, l) => s + l.price * l.qty, 0);
            document.getElementById('cart-total').textContent = peso(total);

            const isCash = method.value === 'Cash';
            cashFields.hidden = !isCash;
            refField.hidden = isCash;
            const change = Math.max(0, (parseFloat(received.value) || 0) - total);
            document.getElementById('cart-change').textContent = peso(change);
        };

        document.querySelectorAll('[data-product]').forEach((tile) => {
            tile.addEventListener('click', () => {
                const found = cart.find((l) => l.id === tile.dataset.id);
                if (found) found.qty += 1; else cart.push({ ...products[tile.dataset.id], qty: 1 });
                render();
            });
        });

        cartLines.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-act]');
            if (!btn) return;
            const id = btn.closest('.cart-line').dataset.id;
            const line = cart.find((l) => l.id === id);
            if (btn.dataset.act === 'inc') line.qty += 1;
            if (btn.dataset.act === 'dec') line.qty -= 1;
            if (btn.dataset.act === 'del' || line.qty <= 0) cart = cart.filter((l) => l.id !== id);
            render();
        });

        method.addEventListener('change', render);
        received.addEventListener('input', render);
        document.getElementById('clear-order').addEventListener('click', () => { cart = []; render(); });

        render();
    }
})();
