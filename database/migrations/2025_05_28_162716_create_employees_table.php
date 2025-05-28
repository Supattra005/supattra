public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('position');
        $table->decimal('salary', 10, 2);
        $table->string('department');
        $table->string('profile_picture')->nullable();
        $table->timestamps();
    });
}
