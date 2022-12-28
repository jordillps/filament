<td colspan="4" class="px-4 py-3 filament-tables-text-column">
    Total:
</td>

<td class="filament-tables-cell">
    <div colspan="6" class="px-4 py-3 filament-tables-text-column text-right">
        @money($this->getTableRecords()->sum('subtotal'), 'eur', true)
    </div>
</td>

<td class="filament-tables-cell">
    <div colspan="6" class="px-4 py-3 filament-tables-text-column text-right">
        @money($this->getTableRecords()->sum('tax'), 'eur', true)
    </div>
</td>

<td class="filament-tables-cell">
    <div colspan="6" class="px-4 py-3 filament-tables-text-column text-right">
        @money($this->getTableRecords()->sum('total'), 'eur', true)
    </div>
</td>