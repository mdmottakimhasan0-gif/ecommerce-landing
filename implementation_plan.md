# Implementation Plan: Order Management Action Icons, Edit Order Modal, and Bangla/English Language Switcher

The user requested 3 major improvements to the Admin Order Management console (`/admin/orders`), as shown in the 4 provided screenshots:
1. **Action Column Icons (Image 2)**: Replace the plain "চালান / ভিউ" button with 4 stylish icon buttons:
   - 🛡️ **Fraud Checker (Red)**: One-click opening of BD Courier Fraud Intelligence modal.
   - 🚚 **Courier Action (Blue)**: Direct parcel booking or jump to order's courier section.
   - 👁️ **View Details (Green)**: View full order details & invoice (`/admin/orders/{id}`).
   - ✏️ **Edit Order (Blue)**: Opens a sleek popup modal to edit order details.
2. **Edit Order Modal (Image 3 & Image 4)**:
   - A modal to edit:
     - **Customer Information**: Customer Name, Phone, Email, Delivery Address.
     - **Status & Financials**: Order Status (Pending, Processing, Shipped, Delivered, Cancelled), Payment Status (Unpaid, Paid, Pending), Subtotal, Delivery Fee.
     - **Grand Total**: Live dynamic recalculation of `Subtotal + Delivery Fee`.
     - Save updates via backend endpoint with validation.
3. **Bangla & English Language Transition (Bilingual Toggle)**:
   - A toggle switch (`[ বাংলা | English ]`) in the Order Management console.
   - When switched to English, all table headers, status labels (Pending, Processing, Shipped, Delivered, Cancelled), courier labels, and UI texts become English.
   - When switched to Bangla, they display in Bangla.
   - The choice is saved persistently in `localStorage` (and session) so it remembers the admin's preference across reloads.

---

## User Review Required

> [!IMPORTANT]
> **Edit Order Calculation**: When Subtotal or Delivery Fee is edited, `total` is automatically re-computed as `subtotal + delivery_charge`.
> **Language Persistence**: The language toggle will remember your selection (`en` or `bn`) using browser `localStorage` and URL/session synchronization so it persists across page visits.

---

## Proposed Changes

### Backend: Order Controller & Routes

#### [MODIFY] [routes/web.php](file:///e:/full%20ecommerce/routes/web.php)
- Add route `PUT /admin/orders/{order}/update-details` (`orders.updateDetails`) for updating customer info, financials, and status.

#### [MODIFY] [app/Http/Controllers/Admin/OrderController.php](file:///e:/full%20ecommerce/app/Http/Controllers/Admin/OrderController.php)
- Add `updateDetails(Request $request, Order $order)`:
  - Validates `customer_name`, `phone`, `email`, `address`, `status`, `payment_status`, `subtotal`, `delivery_charge`.
  - Recalculates `total = subtotal + delivery_charge`.
  - Handles JSON response for AJAX modal update or redirect back with flash message.

---

### Frontend: Order Management Views

#### [MODIFY] [resources/views/admin/orders/index.blade.php](file:///e:/full%20ecommerce/resources/views/admin/orders/index.blade.php)
1. **Add Language Switcher Bar**:
   - Modern toggle button `[ 🇧🇩 বাংলা | 🇬🇧 English ]`.
   - Client-side & server-friendly dictionary that switches all headers, filter tabs, and status badges instantly without losing state.
2. **Action Column Icons (Image 2)**:
   - Four distinct icons in a horizontal row:
     - **Red Shield**: `openFraudChecker(phone)`
     - **Blue Truck**: Courier parcel booking link or jump to order courier block.
     - **Green Eye**: Link to `/admin/orders/{id}`.
     - **Blue Pencil**: `openEditOrderModal(orderData)`
3. **Edit Order Popup Modal (Image 3 & Image 4)**:
   - Replicate the exact design from Image 3:
     - Header: `Edit Order #<id/code>` + close `✕` button.
     - Left: `CUSTOMER INFORMATION` (Name, Email, Phone, Address).
     - Right: `STATUS & FINANCIALS` (Order Status dropdown, Payment Status dropdown, Subtotal, Delivery Fee, `GRAND TOTAL ৳...` highlighted in blue).
     - Footer: `Cancel` and `Update Order` buttons.
   - Instant dynamic calculation of Grand Total when changing Subtotal or Delivery Fee.
   - AJAX submission with real-time row update or clean reload with success toast.

---

## Verification Plan

### Automated Tests
- Feature test in `tests/Feature/OrderManagementTest.php` or `tests/Feature/CourierAndFraudTest.php`:
  - Test admin can update order customer info, financials, and status via `updateDetails`.
  - Verify `total` is correctly re-calculated.
  - Test validation rules.
  - Run `php artisan test --compact`.
  - Run `vendor/bin/pint --format agent`.

### Manual & UI Verification
- Verify action buttons (Red Shield, Blue Truck, Green Eye, Blue Pencil) in the orders table.
- Open Fraud Checker from the Red Shield button.
- Open Edit Order modal from the Blue Pencil button:
  - Test editing Name, Phone, Address, Subtotal, Delivery Fee.
  - Watch live Grand Total calculation.
  - Submit and confirm database update.
- Toggle between বাংলা and English:
  - Verify headers and status badges change instantly.
  - Refresh page to verify preference is preserved.
