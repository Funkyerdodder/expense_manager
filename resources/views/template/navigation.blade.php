<v-navigation-drawer
    color="teal darken-3"
    dark
    app>
    <v-list>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>{{ Auth::user()->name }}</v-list-item-title>
                <v-list-item-subtitle>{{ Auth::user()->role->name }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item link href="{{ route('dashboard') }}">
            <v-list-item-content>
                <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        @if(Auth::user()->isAdmin())
            <v-list-group color="white--text">
                <template v-slot:activator>
                    <v-list-item-title>User Management</v-list-item-title>
                </template>
                <v-list-item link href="{{ route('user.role') }}">
                    <v-list-item-subtitle>Roles</v-list-item-title>
                </v-list-item>
                <v-list-item link href="{{ route('user.manage') }}">
                    <v-list-item-subtitle>Users</v-list-item-title>
                </v-list-item>
            </v-list-group>
        @endif
        <v-list-group color="white--text">
            <template v-slot:activator>
                <v-list-item-title>Expense Management</v-list-item-title>
            </template>
            @if(Auth::user()->isAdmin())
            <v-list-item link href="{{ route('expense.categories') }}">
                <v-list-item-subtitle>Expense Categories</v-list-item-title>
            </v-list-item>
            @endif
            <v-list-item link href="{{ route('expense.manage') }}">
                <v-list-item-subtitle>Expenses</v-list-item-title>
            </v-list-item>
        </v-list-group>
    </v-list>
</v-navigation-drawer>

<v-app-bar
    app
    color="grey lighten-2"
    class="black--text">
    <v-toolbar-title>Expense Manager</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
        <v-btn text href="{{ route('logout') }}">Logout</v-btn>
    </v-toolbar-items>
</v-app-bar>


