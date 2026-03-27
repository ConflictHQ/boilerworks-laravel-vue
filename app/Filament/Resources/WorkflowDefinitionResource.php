<?php

namespace App\Filament\Resources;

use App\Enums\WorkflowStatus;
use App\Filament\Resources\WorkflowDefinitionResource\Pages\CreateWorkflowDefinition;
use App\Filament\Resources\WorkflowDefinitionResource\Pages\EditWorkflowDefinition;
use App\Filament\Resources\WorkflowDefinitionResource\Pages\ListWorkflowDefinitions;
use App\Models\WorkflowDefinition;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkflowDefinitionResource extends Resource
{
    protected static ?string $model = WorkflowDefinition::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    protected static string|\UnitEnum|null $navigationGroup = 'Engines';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options(WorkflowStatus::class)
                ->default(WorkflowStatus::Draft)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('ID')
                    ->limit(8)
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (WorkflowStatus $state): string => match ($state) {
                        WorkflowStatus::Published => 'success',
                        WorkflowStatus::Draft => 'warning',
                        WorkflowStatus::Archived => 'gray',
                    }),
                Tables\Columns\TextColumn::make('instances_count')
                    ->counts('instances')
                    ->label('Instances')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkflowDefinitions::route('/'),
            'create' => CreateWorkflowDefinition::route('/create'),
            'edit' => EditWorkflowDefinition::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
