/**
 * Reusable modal component for create, edit, confirm, and delete actions.
 *
 * Usage:
 *   const modal = new AppModal({
 *     title: 'Edit User',
 *     size: 'lg',
 *     fields: [{ name: 'name', label: 'Name', type: 'text' }],
 *     confirmText: 'Save',
 *     cancelText: 'Cancel',
 *     onSubmit: (formData) => submitForm(formData),
 *     onConfirm: () => doDelete(),
 *     variant: 'destructive',
 *   });
 *   modal.open();
 */

export class AppModal {
    constructor(config = {}) {
        this.config = {
            size: 'md',
            confirmText: 'Confirm',
            cancelText: 'Cancel',
            showConfirm: true,
            showCancel: true,
            variant: 'default',
            method: 'POST',
            ...config,
        };
        this._overlay = null;
        this._formData = {};
        this._escHandler = null;
    }

    open() {
        if (!this._overlay) {
            this._build();
        }
        this._overlay.classList.remove('hidden');
        this._overlay.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        const firstInput = this._overlay.querySelector('input:not([type="hidden"]), select, textarea');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 50);
        }
    }

    close() {
        if (!this._overlay) return;
        this._overlay.classList.remove('flex');
        this._overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        this.clearErrors();
        this._formData = {};
    }

    setLoading(loading) {
        if (!this._overlay) return;
        const btn = this._overlay.querySelector('[data-modal-confirm]');
        if (!btn) return;
        if (loading && !btn.disabled) {
            this._btnOriginalLabel = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="mr-2 h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>Processing...';
        } else if (!loading && this._btnOriginalLabel) {
            btn.disabled = false;
            btn.innerHTML = this._btnOriginalLabel;
            this._btnOriginalLabel = null;
        }
    }

    showErrors(errors) {
        this.clearErrors();
        Object.entries(errors).forEach(([field, messages]) => {
            const input = this._overlay.querySelector(`[name="${field}"]`);
            if (!input) return;
            const errorEl = document.createElement('p');
            errorEl.className = 'mt-1 text-xs text-destructive';
            errorEl.setAttribute('data-field-error', field);
            errorEl.textContent = Array.isArray(messages) ? messages[0] : String(messages);
            input.parentElement.appendChild(errorEl);
            input.classList.add('border-destructive');
        });
    }

    clearErrors() {
        this._overlay.querySelectorAll('[data-field-error]').forEach((el) => el.remove());
        this._overlay.querySelectorAll('.border-destructive').forEach((el) => el.classList.remove('border-destructive'));
    }
    _build() {
        const { title, size, fields, message, confirmText, cancelText, showConfirm, showCancel, variant, onSubmit, onConfirm, onCancel } = this.config;
        this._overlay = document.createElement('div');
        this._overlay.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm';
        this._overlay.setAttribute('role', 'dialog');
        this._overlay.setAttribute('aria-modal', 'true');
        const sizeClass = { sm: 'sm', md: 'md', lg: 'lg', xl: 'xl' }[size] || 'md';
        const confirmBtnClass = variant === 'destructive'
            ? 'bg-destructive text-destructive-foreground hover:opacity-90'
            : 'bg-primary text-primary-foreground hover:opacity-90';
        this._overlay.innerHTML = `<div class="bg-background rounded-lg shadow-xl w-full max-w-${sizeClass} max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between p-4 border-b border-border"><h3 class="text-lg font-semibold text-foreground">${this._escapeHtml(title)}</h3><button type="button" class="text-muted-foreground hover:text-foreground" data-modal-close aria-label="Close"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div><div class="p-4" data-modal-body>${message ? `<p class="text-foreground">${this._escapeHtml(message)}</p>` : ''}${fields && !message ? this._renderFields(fields) : ''}</div><div class="flex justify-end gap-2 p-4 border-t border-border">${showCancel ? `<button type="button" class="px-4 py-2 text-sm rounded-md border border-input bg-card text-foreground hover:bg-accent" data-modal-cancel>${this._escapeHtml(cancelText)}</button>` : ''}${showConfirm ? `<button type="button" class="px-4 py-2 text-sm rounded-md ${confirmBtnClass}" data-modal-confirm>${this._escapeHtml(confirmText)}</button>` : ''}</div></div>`;
        this._overlay.querySelector('[data-modal-close]')?.addEventListener('click', () => { this.close(); onCancel?.(); });
        this._overlay.querySelector('[data-modal-cancel]')?.addEventListener('click', () => { this.close(); onCancel?.(); });
        this._overlay.querySelector('[data-modal-confirm]')?.addEventListener('click', () => { if (onSubmit) { onSubmit(this.getFormData()); } else if (onConfirm) { onConfirm(); } });
        this._overlay.addEventListener('click', (e) => { if (e.target === this._overlay) { this.close(); onCancel?.(); } });
        this._escHandler = (e) => { if (e.key === 'Escape' && !this._overlay.classList.contains('hidden')) { this.close(); onCancel?.(); } };
        document.addEventListener('keydown', this._escHandler);
        document.body.appendChild(this._overlay);
    }

    _renderFields(fields) {
        return fields.map((field) => this._renderField(field)).join('');
    }

    _renderField(field) {
        const id = `modal-field-${field.name}`;
        const baseClass = 'w-full px-3 py-2 text-sm border border-input rounded-md bg-card text-foreground focus:outline-none focus:ring-2 focus:ring-primary';
        const required = field.required ? ' <span class="text-destructive">*</span>' : '';
        switch (field.type) {
            case 'select':
                return `<div class="mb-3"><label class="block text-sm font-medium text-foreground mb-1" for="${id}">${this._escapeHtml(field.label)}${required}</label><select id="${id}" name="${field.name}" class="${baseClass}" ${field.disabled ? 'disabled' : ''} data-field-name="${field.name}">${(field.options || []).map((opt) => `<option value="${this._escapeHtml(String(opt.value))}" ${String(field.value) === String(opt.value) ? 'selected' : ''}>${this._escapeHtml(opt.label)}</option>`).join('')}</select></div>`;
            case 'checkbox':
                return `<div class="mb-3 flex items-center gap-2"><input type="checkbox" id="${id}" name="${field.name}" value="1" ${field.value ? 'checked' : ''} ${field.disabled ? 'disabled' : ''} data-field-name="${field.name}" class="size-4 rounded border-input text-primary focus:ring-primary"><label class="text-sm text-foreground" for="${id}">${this._escapeHtml(field.checkboxLabel || field.label)}</label></div>`;
            default:
                return `<div class="mb-3"><label class="block text-sm font-medium text-foreground mb-1" for="${id}">${this._escapeHtml(field.label)}${required}</label><input type="${field.type || 'text'}" id="${id}" name="${field.name}" class="${baseClass}" value="${this._escapeHtml(String(field.value ?? ''))}" placeholder="${this._escapeHtml(field.placeholder || '')}" ${field.disabled ? 'disabled' : ''} data-field-name="${field.name}"></div>`;
        }
    }

    getFormData() {
        const inputs = this._overlay?.querySelectorAll('[data-field-name]') || [];
        const data = {};
        inputs.forEach((input) => {
            data[input.dataset.fieldName] = input.type === 'checkbox' ? input.checked : input.value;
        });
        return data;
    }

    _escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = String(str);
        return div.innerHTML;
    }

    destroy() {
        if (this._escHandler) { document.removeEventListener('keydown', this._escHandler); }
        if (this._overlay && this._overlay.parentNode) { this._overlay.parentNode.removeChild(this._overlay); }
        this._overlay = null;
    }
}