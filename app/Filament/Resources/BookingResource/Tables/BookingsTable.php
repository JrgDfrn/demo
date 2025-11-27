<?php

namespace App\Filament\Resources\BookingResource\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('customer_phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('start')
                    ->label('Fecha de inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('end')
                    ->label('Fecha de fin')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'confirmed' => 'Confirmada',
                        'pending' => 'Pendiente',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'cancelled' => 'Cancelada',
                    ]),
                Filter::make('start')
                    ->label('Fecha de inicio')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('start_from')
                            ->label('Desde'),
                        \Filament\Forms\Components\DatePicker::make('start_until')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('start', '>=', $date),
                            )
                            ->when(
                                $data['start_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('start', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('start', 'desc')
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}

